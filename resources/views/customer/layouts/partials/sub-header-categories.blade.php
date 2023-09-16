@foreach ($categories as $category)


<section class="sublist-column col">
    <a href="{{ route('customer.products', ['category' => $category->id,'search' => request()->search, 'sort' => request()->sort, 'min_price' => request()->min_price, 'max_price' => request()->max_price, 'brands' => request()->brands]) }}"
        class="sub-category">{{$category->name}}</a>
    @include('customer.layouts.partials.sub-header-categories', ['categories' => $category->children])
</section>

@endforeach
