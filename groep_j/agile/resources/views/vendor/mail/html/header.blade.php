@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Concat')
<img src="{{asset("assets/images/logo-white.png")}}" class="logo" alt="Concat Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
