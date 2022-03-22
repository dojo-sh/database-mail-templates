<?php


namespace DojoSh\DatabaseMailTemplates\Commands;


use DojoSh\DatabaseMailTemplates\Models\MailTemplate;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeTemplateMailableCommand extends Command
{

    protected $signature = 'make:database-mail-template {name} {--notification}';
    protected $description = 'Make Template Mailable Class & DB Record';

    protected $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    public function getMailable()
    {
        return app()->getNamespace() . 'Mail' . '\\' . $this->getMailableClassName();
    }

    public function getMailableClassName()
    {
        return ucwords($this->argument('name')) . 'Mail';
    }

    public function getMailableFilePath()
    {
        return base_path('app/Mail') . '/' . $this->getMailableClassName() . '.php';
    }


    public function getMailableFileContents()
    {
        $contents = file_get_contents(__DIR__ . '/../../stubs/mailable.stub');
        $variables = [
            'NAMESPACE' => app()->getNamespace() . 'Mail',
            'CLASS_NAME' => $this->getMailableClassName(),
        ];
        foreach ($variables as $search => $replace) {
            $contents = str_replace('$' . $search . '$', $replace, $contents);
        }

        return $contents;
    }

    public function getNotificationClassName()
    {
        return ucwords($this->argument('name')) . 'Notification';
    }

    public function getNotificationFilePath()
    {
        return base_path('app/Notifications') . '/' . $this->getNotificationClassName() . '.php';
    }

    public function getNotificationFileContents()
    {
        $contents = file_get_contents(__DIR__ . '/../../stubs/notification.stub');
        $variables = [
            'NAMESPACE' => app()->getNamespace() . 'Notifications',
            'CLASS_NAME' => $this->getNotificationClassName(),
            'MAILABLE_NAMESPACE' => app()->getNamespace() . 'Mail\\' . $this->getMailableClassName(),
            'MAILABLE_CLASS_NAME' => $this->getMailableClassName(),
        ];
        foreach ($variables as $search => $replace) {
            $contents = str_replace('$' . $search . '$', $replace, $contents);
        }

        return $contents;
    }

    protected function makeDirectory($path)
    {
        if (!$this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }
        return $path;
    }

    public function handle()
    {
        $path = $this->getMailableFilePath();
        if ($this->files->exists($path)) {
            $this->error("Mailable $path already exists");
            return 1;
        }
        $pathNotification = null;
        if ($this->option('notification')) {
            $pathNotification = $this->getNotificationFilePath();
            if ($this->files->exists($pathNotification)) {
                $this->error("Notification $path already exists");
                return 1;
            }
        }

        $this->makeDirectory(dirname($path));
        $this->files->put($path, $this->getMailableFileContents());
        $this->info("Created $path");

        if ($this->option('notification')) {
            $this->makeDirectory(dirname($pathNotification));
            $this->files->put($pathNotification, $this->getNotificationFileContents());
            $this->info("Created $pathNotification");
        }

        MailTemplate::create([
            'mailable' => $this->getMailable(),
            'template' => "<x-database-mail-templates::default>
    Body
</x-database-mail-templates::default>",
        ]);


        return 0;
    }


}
