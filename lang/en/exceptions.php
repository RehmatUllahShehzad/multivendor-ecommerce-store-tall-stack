<?php

return [
    'cart_item_quantity_exceed' => 'The quantity limit exceed.',
    'non_purchasable_item' => 'The ":class" model does not implement the purchasable interface.',
    'cart_item_id_mismatch' => 'This cart item does not belong to this cart',
    'invalid_cart_item_quantity' => 'Expected quantity to be at least "1", ":quantity" found.',
    'carts.billing_missing' => 'A billing address is required',
    'carts.billing_incomplete' => 'The billing address is incomplete',
    'carts.order_exists' => 'An order for this cart already exists',
    'missing_currency_price' => 'No price for currency ":currency" exists',
    'fieldtype_missing' => 'FieldType ":class" does not exist',
    'invalid_fieldtype' => 'Class ":class" does not implement the FieldType interface.',
    'product_quantity_exceed' => 'Some items were removed from the cart due to the unavailability of the stock!',
    'payment_exception' => 'Something went wrong please check your payment or card!',
    'payment_attach_exception' => 'Something went wrong please try again',
    'vendor_validate_alert' => 'Sorry! Some items were removed from the cart because you cannot order your own product.',
];
