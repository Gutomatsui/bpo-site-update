@extends('layouts.app')

@section('content')
    <x-hero-slider :slides="$site['slides']" :width="$site['slide_width']" :height="$site['slide_height']" />
    <x-benefits :benefits="$site['benefits']" />
    <x-services :services="$site['services']" />
    <x-workflow :workflow="$site['workflow']" />
    <x-cta :cta="$site['cta']" :contact="$site['contact']" />
    <x-about :about="$site['about']" :director="$site['director']" />
    <x-testimonials :testimonials="$site['testimonials']" :clients="$site['clients']" />
    <x-faq :faq="$site['faq']" />
    <x-contact :contact="$site['contact']" />
@endsection
