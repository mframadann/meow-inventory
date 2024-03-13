<?php

namespace App\Filament\Resources\Product;

use App\Filament\Resources\Product\ProductFlowResource\Pages;
use App\Filament\Resources\Product\ProductFlowResource\RelationManagers;
use App\Models\ProductFlow;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductFlowResource extends Resource
{
    protected static ?string $model = ProductFlow::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrows-right-left';
    protected static ?string $navigationGroup = 'Product';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('amount')->required()->maxLength(255),
            DateTimePicker::make("mutate_at")->label("Mutation Date")->maxDate(now())->required(),
            Select::make('type')
                ->options([
                    'IN' => 'In',
                    'OUT' => 'Out',
                ])
                ->required()
                ->label('Flow Type'),
            Select::make('product_id')
                ->relationship('product', 'name')
                ->preload()
                ->searchable()
                ->createOptionForm([
                    TextInput::make("name")->maxLength(255)->required(),
                    TextInput::make("price")->numeric()->prefix("Rp")->required(),
                    Textarea::make("description")->label("Product Description"),
                    FileUpload::make('img_url')->label("Product Image")->required(),
                ])
                ->required(),
            Textarea::make('desc')->maxLength(16345)->required()->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("product.name")->searchable(),
                TextColumn::make("amount"),
                TextColumn::make("desc"),
                TextColumn::make("type")
                    ->badge()
                    ->getStateUsing(fn (ProductFlow $record): string => $record->type)
                    ->colors([
                        'success' => 'IN',
                        'danger' => "OUT"
                    ]),
                TextColumn::make("mutate_at")->dateTime()->sortable()

            ])
            ->filters([
                SelectFilter::make('type')->label("Mutation Type")->options([
                    "IN" => "IN",
                    "OUT" => "OUT"
                ])
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageProductFlows::route('/'),
        ];
    }
}
