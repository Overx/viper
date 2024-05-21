<?php

namespace App\Filament\Pages;

use App\Models\Customization;
use App\Models\GamesKey;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Support\Exceptions\Halt;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Cache;

class CustomizationPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.customization-page';

    protected static ?string $title = 'Customização';

    protected static ?string $slug = 'customization';


    public ?array $data = [];
    public ?Customization $setting;

    /**
     * @return void
     */
    public function mount(): void
    {
        $gamesKey = Customization::first();
        if(!empty($gamesKey)) {
            $this->setting = $gamesKey;
            $this->form->fill($this->setting->toArray());
        }else{
            $this->form->fill();
        }
    }

    /**
     * @param Form $form
     * @return Form
     */
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Customização de Layout')
                    ->description('Ajustes aparencia do seu Cassino')
                    ->schema([
                        Group::make()->schema([
                            Select::make('card_type')
                                ->label('Tipo de Card')
                                ->placeholder('Altere o card de listagem de jogos')
                                ->options([
                                    'default' => 'Padrão',
                                    'basic' => 'Básica',
                                    'modern' => 'Moderna',
                                ]),
                            Select::make('header_type')
                                ->label('Tipo de Cabeçalho')
                                ->placeholder('Altere o Cabeçalho do seu site')
                                ->options([
                                    'default' => 'Padrão',
                                    'basic' => 'Básica',
                                    'modern' => 'Moderna',
                                ]),
                            Select::make('side_type')
                                ->label('Tipo de Menu Side')
                                ->placeholder('Altere o menu lateral esqueda do seu site')
                                ->options([
                                    'default' => 'Padrão',
                                    'basic' => 'Básica',
                                    'modern' => 'Moderna',
                                ]),
                            Select::make('footer_type')
                                ->label('Tipo de Rodapé')
                                ->placeholder('Altere o rodapé')
                                ->options([
                                    'default' => 'Padrão',
                                    'basic' => 'Básica',
                                    'modern' => 'Moderna',
                                ]),
                        ])->columns(3),

                        Group::make()->schema([
                            ColorPicker::make('primary_color')
                                ->label('Cor Primaria'),
                            ColorPicker::make('primary_border_color')
                                ->label('Cor da Borda Primaria'),
                            ColorPicker::make('primary_text')
                                ->label('Cor do Texto'),
                            ColorPicker::make('secondary_color')
                                ->label('Cor Secundaria'),
                            ColorPicker::make('background_color')
                                ->label('Cor do Fundo'),
                            ColorPicker::make('footer_color')
                                ->label('Cor do Rodapé'),

                        ])->columns(4),

                        Toggle::make('expanded_layout')
                            ->label('Layout Expandido')
                        ,


                    ]),
            ])
            ->statePath('data');
    }


    /**
     * @return void
     */
    public function submit(): void
    {
        try {
            if(env('APP_DEMO')) {
                Notification::make()
                    ->title('Atenção')
                    ->body('Você não pode realizar está alteração na versão demo')
                    ->danger()
                    ->send();
                return;
            }

            $setting = Customization::first();
            if(!empty($setting)) {
                if($setting->update($this->data)) {
                    Cache::put('customlayout', $setting);

                    Notification::make()
                        ->title('Chaves Alteradas')
                        ->body('Suas chaves foram alteradas com sucesso!')
                        ->success()
                        ->send();
                }
            }else{
                if(Customization::create($this->data)) {
                    Notification::make()
                        ->title('Chaves Criadas')
                        ->body('Suas chaves foram criadas com sucesso!')
                        ->success()
                        ->send();
                }
            }


        } catch (Halt $exception) {
            Notification::make()
                ->title('Erro ao alterar dados!')
                ->body('Erro ao alterar dados!')
                ->danger()
                ->send();
        }
    }
}
