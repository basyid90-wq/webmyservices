<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class Settings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 99;

    protected static string $view = 'filament.pages.settings';

    public ?array $data = [];

    protected $settings = [
        'site_name',
        'hero_headline',
        'hero_subtext',
        'about_text',
        'contact_email',
        'contact_phone',
        'facebook_url',
        'twitter_url',
        'linkedin_url',
        'github_url',
    ];

    public function mount(): void
    {
        $data = [];

        foreach ($this->settings as $key) {
            $data[$key] = SiteSetting::get($key);
        }

        $this->form->fill($data);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('site_name')
                    ->label('Site Name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('hero_headline')
                    ->label('Hero Headline')
                    ->maxLength(255),
                Textarea::make('hero_subtext')
                    ->label('Hero Subtext')
                    ->rows(3),
                Textarea::make('about_text')
                    ->label('About Text')
                    ->rows(5),
                TextInput::make('contact_email')
                    ->label('Contact Email')
                    ->email()
                    ->maxLength(255),
                TextInput::make('contact_phone')
                    ->label('Contact Phone')
                    ->tel()
                    ->maxLength(255),
                TextInput::make('facebook_url')
                    ->label('Facebook URL')
                    ->url()
                    ->maxLength(255),
                TextInput::make('twitter_url')
                    ->label('Twitter URL')
                    ->url()
                    ->maxLength(255),
                TextInput::make('linkedin_url')
                    ->label('LinkedIn URL')
                    ->url()
                    ->maxLength(255),
                TextInput::make('github_url')
                    ->label('GitHub URL')
                    ->url()
                    ->maxLength(255),
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        $data = $this->form->getState();

        foreach ($this->settings as $key) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $data[$key] ?? '']
            );
        }

        Notification::make()
            ->title('Settings saved successfully.')
            ->success()
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            \Filament\Actions\Action::make('save')
                ->label('Save Settings')
                ->submit('submit'),
        ];
    }
}
