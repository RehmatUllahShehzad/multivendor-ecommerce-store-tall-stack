<?php

namespace App\Http\Livewire\Frontend\Traits;

use App\Models\Conversation;
use Exception;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\TemporaryUploadedFile;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait WithSendMessage
{
    public string $receiverName = '';

    public ?Conversation $conversation = null;

    public TemporaryUploadedFile|Media|string|null $file = null;

    /**
     * Define the validation rules.
     *
     * @return array<mixed>
     */
    protected function rules()
    {
        return [
            'textMessage' => 'bail|required|string',
            'file' => 'nullable|mimes:doc,csv,xlsx,xls,docx,pdf,mp4,jpg,jpeg,mp4,wmv,avi|max:3072',
        ];
    }

    public function updatedFile()
    {
        if (! $this->file) {
            return;
        }

        try {
            $this->validateOnly('file');
        } catch (Exception $ex) {
            $this->removeAttachment();
            throw $ex;
        }
    }

    public function getConversationMessages(): Paginator
    {
        if (! $this->conversation) {
            return new LengthAwarePaginator([], 0, 10);
        }

        return $this->conversation
            ->messages()
            ->with('media', 'sender')
            ->paginate(10);
    }

    public function sendMessage(): void
    {
        $this->validate();

        DB::beginTransaction();

        try {
            if (! $this->conversation) {
                $this->conversation = Conversation::create(['order_package_id' => $this->orderPackage->id]);
            }

            $this->message = $this->conversation->messages()->create([
                'sender_id' => Auth::id(),
                'receiver_id' => $this->receiver->id,
                'message' => $this->textMessage,
            ]);

            if ($this->file instanceof TemporaryUploadedFile) {
                $this->message->addMedia($this->file->getRealPath())
                    ->usingName($this->file->getClientOriginalName())
                    ->usingFileName($this->file->getClientOriginalName())
                    ->toMediaCollection(
                        get_class($this->message)
                    );
                $this->removeUpload('file', $this->file->getFilename());
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->emit('alert-danger', 'Error: '.$th->getMessage());

            return;
        }

        $this->resetFields();

        $this->emit('alert-success', trans('notifications.message.send'));
    }

    public function removeAttachment(): void
    {
        if ($this->file instanceof TemporaryUploadedFile) {
            $this->removeUpload('file', $this->file->getFilename());
        }
    }

    public function resetFields(): void
    {
        $this->textMessage = '';
        $this->file = null;
    }
}
