<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\Colors\Color;
use Filament\Tables\Filters\SelectFilter;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    /**
     * To enable global search on your model, you must set a title attribute for your resource:
     * this will be used for the global search.
     */
    protected static ?string $recordTitleAttribute = 'email';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                section::make('User Information')->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Full Name')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan('full')
                        ->placeholder('Enter the user name'),

                    Forms\Components\TextInput::make('email')
                        ->label('Email Address')
                        ->email()
                        ->required()
                        ->maxLength(255)
                        ->placeholder('Enter the user email'),

                    Forms\Components\TextInput::make('password')
                        ->label('Password')
                        ->password()
                        ->password()
                        ->dehydrated(fn($state) => filled($state)) // check if not empty
                        ->required(fn(Page $livewire): bool => $livewire instanceof CreateRecord) // the password field is mandatory if its create record (create new user)
                        ->maxLength(255)
                        ->minLength(8)
                        ->placeholder('Enter password')
                        ->helperText('Password must contain at least one letter, one number, and one special character'),
                ]),

                Section::make('User privileges')->schema(
                    [
                        ToggleButtons::make('role')
                            ->label('')
                            ->inline()
                            ->options([
                                'driver' => 'Driver',
                                'admin' => 'Admin',
                            ])
                            ->colors([
                                'driver' =>  Color::Indigo,
                                'admin' =>  Color::Rose,
                            ])
                            ->icons([
                                'driver' => 'heroicon-o-truck',
                                'admin' => 'heroicon-o-shield-check',
                            ])
                            ->default('driver')

                    ]
                ),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable(),

                Tables\Columns\TextColumn::make('role')
                    ->searchable()
                    ->badge()
                    ->color(fn(string $state) => match ($state) {
                        'driver' =>  Color::Indigo,
                        'admin' =>  Color::Rose,
                    })
                    ->icon(fn(string $state) => match ($state) {
                        'driver' => 'heroicon-o-truck',
                        'admin' => 'heroicon-o-shield-check',
                    })
                    ->formatStateUsing(fn(string $state): string => ucfirst($state)), // capitalize the first letter

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),


            ])
            ->filters([
                // Role filter
                SelectFilter::make('role')
                    ->options([
                        'driver' => 'Drivers',
                        'admin' => 'Admins',
                    ])

            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\DeleteAction::make(),

                ]),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
