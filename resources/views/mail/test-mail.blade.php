<x-mail::message>
# Introduction

Hello {{ is_object(json_decode($user)) ? json_decode($user)->name : 'Guest' }},

<x-mail::button :url="''">
        Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
