@foreach ($categories as $category)
    <section class="sublist-item">

        <section class="sublist-item-toggle">   <a href="{{ route('customer.products', ['category' => $category->id,'search' => request()->search, 'sort' => request()->sort, 'min_price' => request()->min_price, 'max_price' => request()->max_price, 'brands' => request()->brands]) }}"
                                                   class="sub-category">{{$category->name}}</a></section>

        <section class="sublist-item-sublist">
            <section
                class="sublist-item-sublist-wrapper d-flex justify-content-around align-items-center">
                @if($category->children->count() > 0)
                @include('customer.layouts.partials.sub-header-categories', ['categories' => $category->children])
                @endif
            </section>
        </section>
    </section>
@endforeach
