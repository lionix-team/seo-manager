<?php

use Lionix\SeoManager\Facades\SeoManager;

if (!function_exists('metaData')) {
    function metaData($property = null)
    {
        return SeoManager::/** @scrutinizer ignore-call */metaData($property);
    }
}

if (!function_exists('metaKeywords')) {
    function metaKeywords()
    {
        return SeoManager::/** @scrutinizer ignore-call */metaKeywords();
    }
}

if (!function_exists('metaTitle')) {
    function metaTitle()
    {
        return SeoManager::/** @scrutinizer ignore-call */metaTitle();
    }
}
if (!function_exists('metaUrl')) {
    function metaUrl()
    {
        return SeoManager::/** @scrutinizer ignore-call */metaUrl();
    }
}

if (!function_exists('metaAuthor')) {
    function metaAuthor()
    {
        return SeoManager::/** @scrutinizer ignore-call */metaAuthor();
    }
}

if (!function_exists('metaDescription')) {
    function metaDescription()
    {
        return SeoManager::/** @scrutinizer ignore-call */metaDescription();
    }
}

if (!function_exists('metaTitleDynamic')) {
    function metaTitleDynamic()
    {
        return SeoManager::/** @scrutinizer ignore-call */metaTitleDynamic();
    }
}

if (!function_exists('metaOpenGraph')) {
    function metaOpenGraph($property = null)
    {
        return SeoManager::/** @scrutinizer ignore-call */metaOpenGraph($property);
    }
}
