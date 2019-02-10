<?php

use Lionix\SeoManager\Facades\SeoManager;

if (!function_exists('metaData')) {
    function metaData($property = null)
    {
        return SeoManager::metaData($property);
    }
}

if (!function_exists('metaKeywords')) {
    function metaKeywords()
    {
        return SeoManager::metaKeywords();
    }
}

if (!function_exists('metaTitle')) {
    function metaTitle()
    {
        return SeoManager::metaTitle();
    }
}
if (!function_exists('metaUrl')) {
    function metaUrl()
    {
        return SeoManager::metaUrl();
    }
}

if (!function_exists('metaAuthor')) {
    function metaAuthor()
    {
        return SeoManager::metaAuthor();
    }
}

if (!function_exists('metaDescription')) {
    function metaDescription()
    {
        return SeoManager::metaDescription();
    }
}

if (!function_exists('metaTitleDynamic')) {
    function metaTitleDynamic()
    {
        return SeoManager::metaTitleDynamic();
    }
}

if (!function_exists('metaOpenGraph')) {
    function metaOpenGraph($property = null)
    {
        return SeoManager::metaOpenGraph($property);
    }
}
