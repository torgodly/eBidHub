@props(['markdown'])

{{--<div id="{{ $attributes->get('id', 'markdownOutput') }}">--}}
{{--    {{ $markdown }}--}}
{{--</div>--}}
<div id="content"></div>
<div id="mark" hidden="">{!! $markdown !!}</div>

@push('scripts')
{{--    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>--}}
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script>

        document.getElementById('content').innerHTML =
            marked.parse(document.getElementById('mark').innerText);
    </script
@endpush
