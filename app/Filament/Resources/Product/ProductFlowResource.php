<?php

namespace App\Filament\Resources\Product;

use App\Filament\Resources\Product\ProductFlowResource\Pages;
use App\Models\ProductFlow;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProductFlowResource extends Resource
{
    protected static ?string $model = ProductFlow::class;
    protected static ?string $slug = 'product/mutations';
    protected static ?string $navigationIcon = 'heroicon-o-arrows-right-left';
    protected static ?string $navigationGroup = 'Product';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('amount')->required()->maxLength(255),
            DateTimePicker::make('mutate_at')->label('Mutation Date')->maxDate(now())->required(),
            Select::make('type')
                ->options([
                    'IN' => 'IN',
                    'OUT' => 'OUT',
                ])
                ->required()
                ->label('Flow Type')
                ->live()
                ->afterStateUpdated(fn (Select $component) => $component->getContainer()->getComponent('productField')->getChildComponentContainer()->fill())->columnSpanFull(),
             Grid::make(1)->schema(
                 fn (Get $get): array => match ($get('type')) {
                     'IN' => [
                         Select::make('product_id')
                             ->relationship(name: 'product', titleAttribute: 'name')
                             ->preload()
                             ->searchable()
                             ->createOptionForm([TextInput::make('name')->maxLength(255)->required(), TextInput::make('price')->numeric()->prefix('Rp')->required(), Textarea::make('description')->label('Product Description'), FileUpload::make('img_url')->label('Product Image')->required()])
                             ->required(),
                     ],
                     'OUT' => [
                         Select::make('product_id')
                             ->relationship(
                                 name: 'product',
                                 titleAttribute: 'name',
                                 modifyQueryUsing: function (Builder $query) {
                                     $query
                                         ->whereRaw('COALESCE((SELECT SUM(amount) FROM tb_product_flows WHERE tb_products.product_id = tb_product_flows.product_id AND type = "IN"), 0) - COALESCE((SELECT SUM(amount) FROM tb_product_flows WHERE tb_products.product_id = tb_product_flows.product_id AND type = "OUT"), 0) > 0');
                                 },
                             )
                             ->preload()
                             ->searchable()
                             ->required(),
                     ],
                     default => [],
                 },
             )->key('productField'),
            Textarea::make('desc')->maxLength(16345)->required()->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product.name')->searchable(),
                TextColumn::make('amount'),
                TextColumn::make('desc'),
                TextColumn::make('type')
                    ->badge()
                    ->getStateUsing(fn (ProductFlow $record): string => $record->type)
                    ->colors([
                        'success' => 'IN',
                        'danger' => 'OUT',
                    ]),
                TextColumn::make('mutate_at')->dateTime()->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Mutation type')
                    ->options([
                        'IN' => 'IN',
                        'OUT' => 'OUT',
                    ]),
                SelectFilter::make('product')->relationship('product', 'name'),
                Filter::make('mutate_at')
                    ->form([DatePicker::make('mutate_at')])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when($data['mutate_at'], fn (Builder $query, $date): Builder => $query->whereDate('mutate_at', '>=', $date));
                    }),
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
