<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/admin/check-password',
        '/admin/check-brand-url',
        '/admin/check-category-url',
        '/admin/check-product-url',
        '/admin/check-product-code',
        '/admin/check-attribute-code',
        '/admin/update-status-section',
        '/admin/update-status-category',
        '/admin/append-category-level',
        '/admin/update-status-product',
        '/admin/update-status-attribute',
        '/admin/update-status-image',
        '/admin/update-status-brand',
        '/admin/update-status-banner',
        '/admin/update-status-filter',
        '/admin/update-status-filter_value',
        '/admin/check-filter-value',
        '/admin/update-status-coupon',
        '/admin/update-status-orderstatus',
        '/admin/update-status-delivery_charge',
        '/admin/update-status-delivery_charge_by_weight',
        '/admin/update-status-pincode_cod',
        '/admin/update-status-pincode_prepaid',
        '/admin/get-state',
        '/admin/get-cities',
        '/get-attr-price',
        '/cart-qty-updated',
        '/get-country-pincode',
    ];
}
