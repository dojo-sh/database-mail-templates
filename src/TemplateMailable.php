<?php


namespace DojoSh\DatabaseMailTemplates;

use DojoSh\DatabaseMailTemplates\Models\MailTemplate;
use Illuminate\Mail\Mailable;
use Illuminate\Support\HtmlString;

abstract class TemplateMailable extends Mailable
{
    protected $mailTemplate;

    public function getMailTemplate()
    {
        return $this->mailTemplate ?? $this->resolveTemplateModel();
    }

    protected function resolveTemplateModel()
    {
        return $this->mailTemplate = MailTemplate::findForMailable($this);
    }

    protected function buildSubject($message)
    {
        if ($this->subject) {
            $message->subject($this->subject);

            return $this;
        }

        $mailTemplate = $this->getMailTemplate();

        if ($mailTemplate && $mailTemplate->subject) {
            $data = $this->buildViewData();
            $subject = app(TemplateMailableRenderer::class)->render($mailTemplate, 'subject', $data);
            $message->subject($subject);

            return $this;
        }

        return parent::buildSubject($message);
    }

    protected function buildView()
    {
        $data = $this->buildViewData();

        $mailTemplate = $this->getMailTemplate();
        $html = app(TemplateMailableRenderer::class)->render($mailTemplate, 'template', $data);

        return array_filter([
            'html' => new HtmlString($html),
            'text' => null,
        ]);
    }

    public function build()
    {
        return $this;
    }

    public static function getPreviewInstance()
    {
        return null;
    }
}
