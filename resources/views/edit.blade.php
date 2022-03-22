@extends('database-mail-templates::layouts.app')

@section('content')
    <div class="container">
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{session('message')}}
            </div>
        @endif

        <a href="{{route('database-mail-templates.index')}}" class="btn btn-secondary mb-3"><i class="fa fa-arrow-left"></i> Back</a>
        <h1 class="mb-3">{{$template->mailable}}</h1>

        <form action="{{route('database-mail-templates.update', $template)}}" method="POST">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label>Subject</label>
                <input type="text" class="form-control" name="subject" value="{{$template->subject}}">
            </div>

            <div class="form-group">
                <label>
                    Template
                    @if ($template->mailable::getPreviewInstance())
                        <a href="{{route('database-mail-templates.preview', $template)}}" target="_blank"><i class="fa fa-eye"></i></a>
                    @endif
                </label>

                <div id="editor" style="width: 100%; height: 500px">{{$template->template}}</div>
                <textarea name="template" style="display: none;">{{$template->template}}</textarea>
            </div>

            <button class="btn btn-success">Save</button>
        </form>
    </div>
@endsection


@push('scripts')
    <script>
        ace.config.set('basePath', 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.14/')
        var editor = ace.edit("editor");
        editor.setTheme("ace/theme/monokai");
        editor.session.setMode("ace/mode/php_laravel_blade");

        var textarea = $('textarea[name="template"]');
        editor.getSession().on("change", function () {
            textarea.val(editor.getSession().getValue());
        });
    </script>
@endpush
