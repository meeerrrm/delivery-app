<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CustomerResource extends Resource
{

    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $navigationGroup = 'Customer Management';

    public static function canViewAny(): bool
    {
        return Auth::user()->hasRole(['Super Admin','Admin']);
    }
    public static function form(Form $form): Form
    {

        return $form->schema([
            TextInput::make('company_name')->required()->label('Nama Perusahaan'),
            Textarea::make('company_address')->label('Alamat'),
            Select::make('user_id')
                ->label('Akun Customer')
                ->options(
                    User::role('Customer')->pluck('name', 'id')->toArray()
                )
                ->searchable()
                ->preload()
                ->required(),
            TextInput::make('industry')->label('Bidang Usaha'),
            FileUpload::make('logo')->directory('customer-logos')->image()->label('Logo Perusahaan'),
            Repeater::make('company_contacts')
                ->label('Kontak Perusahaan')
                ->schema([
                    TextInput::make('name')->label('Nama')->required(),
                    TextInput::make('position')->label('Jabatan')->required(),
                    TextInput::make('phone')->label('No. Telepon')->tel()->required(),
                ])
                ->addActionLabel('Tambah Kontak')
                ->collapsible()
                ->grid(3)
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')->circular(),
                TextColumn::make('company_name')->searchable(),
                TextColumn::make('company_contacts')
                    ->label('Kontak Utama')
                    ->formatStateUsing(function ($state){

                        Log::debug('Company Contacts State:', [
                            'type' => gettype($state),
                            'value' => $state,
                            'is_array' => is_array($state),
                            'is_json' => json_decode($state, true)
                        ]);
                    }),
                TextColumn::make('industry'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
