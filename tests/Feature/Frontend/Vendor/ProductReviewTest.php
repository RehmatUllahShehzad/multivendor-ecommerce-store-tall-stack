<?php

namespace Tests\Feature\Frontend\Vendor;

use App\Enums\ReviewStatus;
use App\Http\Livewire\Frontend\Vendor\Review\ReviewIndexController;
use App\Http\Livewire\Frontend\Vendor\Review\ReviewShowController;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\WithLogin;

class ProductReviewTest extends TestCase
{
    use WithLogin;

    public function test_guest_user_cannot_access_vendor_product_review_page()
    {
        $response = $this->get(route('vendor.reviews'));
        $response->assertRedirect(
            route('login')
        );
    }

    public function test_authorized_user_can_access_vendor_product_review_page()
    {
        $this->loginUser(true);
        $response = $this->get(route('vendor.reviews'));
        $response->assertOk();
    }

    public function test_authorized_vendor_can_view_all_of_his_products_reviews()
    {
        $this->loginUser();

        $review = Review::factory()
            ->for(User::factory())
            ->for(
                Product::factory()
                    ->for(User::factory())
            )
            ->for(
                Order::factory()
                    ->for(Cart::factory()
                        ->for(User::factory()))
            )
            ->count(1)
            ->create()
            ->first();

        $response = Livewire::test(ReviewIndexController::class)
            ->call('render');

        $response->assertSee($review->rating)
            ->assertOk();
    }

    public function test_vendor_can_sort_products_reviews_record()
    {
        $this->loginUser();

        $review = Review::factory()
            ->for(User::factory())
            ->for(
                Product::factory()
                    ->for(User::factory())
            )
            ->for(
                Order::factory()
                    ->for(Cart::factory()
                        ->for(User::factory()))
            )
            ->count(5)
            ->create();

        /** Test Sort By Newest order */
        $response = Livewire::test(ReviewIndexController::class)
            ->set('sortBy', 'newest')
            ->call('render');

        $response->assertSeeInOrder([
            $review[2][3],
            $review[1][2],
            $review[0][1],
        ]);

        /** Test Sort By Newest order */
        $response = Livewire::test(ReviewIndexController::class)
            ->set('sortBy', 'oldest')
            ->call('render');

        $response->assertSeeInOrder([
            $review[0][1],
            $review[1][2],
            $review[2][3],
        ]);
    }

    public function test_authorized_vendor_can_approved_review_of_product()
    {
        $user = User::factory()->count(1)->create()->first();

        $review = Review::factory()
            ->for($user)
            ->for(
                Product::factory()
                    ->for($user)
            )
            ->for(
                Order::factory()
                    ->for(Cart::factory()
                        ->for($user))
            )
            ->count(5)
            ->create()
            ->first();

        $response = Livewire::actingAs($user)
            ->test(ReviewShowController::class, [
                'review' => $review,
            ])
            ->call('markApproved');

        $review->status = ReviewStatus::APPROVED;

        $response->assertOk();

        $this->count(1, Review::query()->approved()->get());
    }

    public function test_authorized_vendor_can_reject_review_of_product()
    {
        $user = User::factory()->count(1)->create()->first();

        $review = Review::factory()
            ->for($user)
            ->for(
                Product::factory()
                    ->for($user)
            )
            ->for(
                Order::factory()
                    ->for(Cart::factory()
                        ->for($user))
            )
            ->count(5)
            ->create()
            ->first();

        $response = Livewire::actingAs($user)
            ->test(ReviewShowController::class, [
                'review' => $review,
            ])
            ->call('markRejected');

        $review->status = ReviewStatus::REJECTED;

        $response->assertOk();

        $this->count(1, Review::query()->rejected()->get());
    }

    public function test_authorized_vendor_can_reply_of_product_review()
    {
        $user = User::factory()->count(1)->create()->first();

        $review = Review::factory()
            ->for($user)
            ->for(
                Product::factory()
                    ->for($user)
            )
            ->for(
                Order::factory()
                    ->for(Cart::factory()
                        ->for($user))
            )
            ->count(5)
            ->create()
            ->first();

        $response = Livewire::actingAs($user)
            ->test(ReviewShowController::class, [
                'review' => $review,
            ])
            ->set('review.vendor_reply', 'Corporis qui tempori')
            ->call('submit');

        $response->assertHasNoErrors()
            ->assertStatus(200);

        $this->assertCount(1, Review::where('id', $review->id)->get());
    }
}
