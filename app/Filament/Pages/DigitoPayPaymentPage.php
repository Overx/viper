<?php

namespace App\Filament\Pages;

use App\Livewire\LatestPixPayments;
use App\Models\DigitoPayPayment;
use App\Models\User;
use App\Traits\Gateways\DigitoPayTrait;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class DigitoPayPaymentPage extends Page
{
    use DigitoPayTrait;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static string $view = 'filament.pages.digitopay-payment-page';

    protected static ?string $navigationLabel = 'DigitoPay Pagamentos';

    protected static ?string $modelLabel = 'DigitoPay Pagamentos';

    protected static ?string $title = 'DigitoPay Pagamentos';

    protected static ?string $slug = 'digitopay-pagamentos';

    public ?array $data = [];
    public DigitoPayPayment $digitoPayPayment;

    /**
     * @return void
     */
    public function mount(): void
    {
        $this->form->fill();
    }

    /**
     * @param Form $form
     * @return Form
     */
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Detalhes de Pagamento')
                    ->schema([
                        Select::make('user_id')
                            ->label('Usuários')
                            ->placeholder('Selecione um usuário')
                            ->relationship(name: 'user', titleAttribute: 'name')
                            ->options(
                                fn($get) => User::query()
                                    ->pluck('name', 'id')
                            )
                            ->searchable()
                            ->preload()
                            ->live()
                            ->required(),
                        TextInput::make('pix_key')
                            ->label('Chave Pix')
                            ->placeholder('Digite a chave Pix')
                            ->required(),
                        Select::make('pix_type')
                            ->label('Tipo de Chave')
                            ->placeholder('Selecione o tipo de chave')
                            ->options([
                                'document' => 'Documento',
                                'phoneNumber' => 'Telefone',
                                'randomKey' => 'Chave aleatória',
                                'paymentCode' => 'Código de pagamento',
                            ]),
                        TextInput::make('amount')
                            ->label('Valor')
                            ->placeholder('Digite um valor')
                            ->required()
                            ->numeric(),
                        Textarea::make('observation')
                            ->label('Observação')
                            ->placeholder('Deixe uma observação caso tenha')
                            ->rows(5)
                            ->cols(10)
                            ->columnSpanFull()
                    ])->columns(2),
            ])
            ->statePath('data');
    }

    /**
     * @return void
     */
    public function submit(): void
    {
        if(env('APP_DEMO')) {
            Notification::make()
                ->title('Atenção')
                ->body('Você não pode realizar está alteração na versão demo')
                ->danger()
                ->send();
            return;
        }


        $digitoPayPayment = DigitoPayPayment::create([
            'user_id'       => $this->data['user_id'],
            'pix_key'       => $this->data['pix_key'],
            'pix_type'      => $this->data['pix_type'],
            'amount'        => $this->data['amount'],
            'observation'   => $this->data['observation'],
        ]);

        if($digitoPayPayment) {
            $resp = self::pixCashOut([
                'pix_key' => $this->data['pix_key'],
                'pix_type' => $this->data['pix_type'],
                'amount' => $this->data['amount'],
                'payment_id' => $digitoPayPayment->id
            ]);

            if($resp) {
                Notification::make()
                    ->title('Saque solicitado')
                    ->body('Saque solicitado com sucesso')
                    ->success()
                    ->send();
            }else{
                Notification::make()
                    ->title('Erro no saque')
                    ->body('Erro ao solicitar o saque')
                    ->danger()
                    ->send();
            }
        }else{
            Notification::make()
                ->title('Erro ao salvar')
                ->body('Erro ao salvar a requisição do saque')
                ->danger()
                ->send();
        }
    }

    /**
     * @return array|\Filament\Widgets\WidgetConfiguration[]|string[]
     */
    public function getFooterWidgets(): array
    {
        return [
            LatestPixPayments::class
        ];
    }
}
