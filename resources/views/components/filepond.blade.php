@props(['source'])
@php
    $mimesTypes = $attributes->has('accept') ? json_encode(explode(',', str_replace(' ', '', $attributes->get('accept')))) : "[]";
    $name = $attributes->has('name') ? $attributes->get('name') : '';
@endphp
<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-crop/dist/filepond-plugin-image-crop.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.js"></script>

<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">

<!-- Include the scripts for FilePond and the necessary plugins -->
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script
    src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>

<div x-data
     x-init="() => {
        FilePond.registerPlugin(
          FilePondPluginImagePreview,
          FilePondPluginImageExifOrientation,
          FilePondPluginFileValidateType
        );

        const post = FilePond.create($refs.input);
        post.setOptions({
            allowMultiple: {{ $attributes->has('multiple') ? 'true' : 'false' }},
            acceptedFileTypes: JSON.parse('{{ $mimesTypes }}'),
            storeAsFile: true,
            imageCropAspectRatio: '1:1',
            imageResizeTargetWidth: 150, // match with the CSS width
            imageResizeTargetHeight: 150, // match with the CSS height
        });
    }"
>
    <input type="file" x-ref="input" class="mt-2" name="{{ $name }}"/>
</div>

{{--<style>--}}
{{--    /* Style for the FilePond input area */--}}
{{--    .filepond--root {--}}
{{--        border-radius: 50%;--}}
{{--        overflow: hidden;--}}
{{--        width: 150px; /* adjust as needed */--}}
{{--        height: 150px; /* adjust as needed */--}}
{{--        border: 2px solid #ddd; /* optional, for styling */--}}
{{--    }--}}

{{--    /* Style for the image preview */--}}
{{--    .filepond--image-preview-wrapper {--}}
{{--        border-radius: 50%;--}}
{{--        overflow: hidden;--}}
{{--    }--}}
{{--</style>--}}

