<?php

namespace App\Http\Livewire\Frontend\Newsletter;

use Exception;
use GuzzleHttp\Exception\BadResponseException;
use Livewire\Component;
use MailchimpMarketing\ApiClient;
use MailchimpMarketing\ApiException;

class Newsletter extends Component
{
    public $email;

    public function mount()
    {
        $this->resetFields();
    }

    public function render()
    {
        return view('frontend.newsletter.newsletter');
    }

    public function submit()
    {
        $this->validate([
            'email' => 'bail|required|email:filter,rfc,dns|max:191',
        ]);

        $mailchimp = new ApiClient();

        $mailchimp->setConfig([
            'apiKey' => config('services.mailchimp.api_key'),
            'server' => config('services.mailchimp.server_prefix'),
        ]);
        try {
            $response = $mailchimp->lists->addListMember(config('services.mailchimp.list_id'), [
                'email_address' => $this->email,
                'status' => 'subscribed',
            ]);
            $this->emit('alert-success', 'You successfully subscribed to our newsletter.');
            $this->resetFields();
        } catch (ApiException $e) {
            $this->emit('alert-danger', $e->getMessage());
        } catch (BadResponseException $e) {
            $response = $e->getResponse()->getBody()->getContents();
            if ($data = json_decode($response)) {
                if (($detail = optional($data)->detail) && str_contains($detail, 'already')) {
                    $this->emit('alert-danger', 'You are already subscribed.');

                    return;
                }
                $this->emit('alert-danger', optional($data)->detail);

                return;
            }
            $this->emit('alert-danger', $e->getMessage());
        } catch (Exception $e) {
            $this->emit('alert-danger', $e->getMessage());
        }
    }

    private function resetFields()
    {
        $this->email = '';
    }
}
