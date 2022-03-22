<?php


namespace DojoSh\DatabaseMailTemplates\Http\Controllers;


use DojoSh\DatabaseMailTemplates\Models\MailTemplate;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DatabaseMailTemplateController extends Controller
{
    public function index()
    {
        $templates = MailTemplate::all();
        return view('database-mail-templates::index')->with(compact('templates'));
    }

    public function edit($id)
    {
        $template = MailTemplate::find($id); // injection of MailTemplate $database_mail_template not working!!
        return view('database-mail-templates::edit')->with(compact('template'));
    }

    public function update($id, Request $request)
    {
        $template = MailTemplate::find($id);
        $template->update([
            'subject' => $request->subject,
            'template' => $request->template,
        ]);

        session()->put('message', 'Saved!');
        return redirect()->route('database-mail-templates.edit', $template);
    }

    public function preview($id)
    {
        $template = MailTemplate::find($id);

        return $template->mailable::getPreviewInstance();
    }
}
