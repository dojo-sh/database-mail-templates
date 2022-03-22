@extends('database-mail-templates::layouts.app')

@section('content')
    <div class="container">
        <h1>Mail Templates</h1>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Subject</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($templates as $template)
                    <tr>
                        <td>
                            <a href="{{route('database-mail-templates.edit', $template)}}">
                                {{$template->mailable}}
                            </a>
                        </td>
                        <td>{{$template->subject}}</td>
                        <td>
                            <a href="{{route('database-mail-templates.edit', $template)}}"><i class="fa fa-edit"></i></a>
                            @if ($template->mailable::getPreviewInstance())
                                <a href="{{route('database-mail-templates.preview', $template)}}" target="_blank"><i class="fa fa-eye"></i></a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
