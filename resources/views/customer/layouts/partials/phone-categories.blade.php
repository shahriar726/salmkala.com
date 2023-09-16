@foreach ($categories as $category)
<section class="sidebar-nav-item">
      <span class="sidebar-nav-item-title">

        {{ $category->name }}

          @if($category->children->count() > 0)
              <i class="fa fa-angle-left"></i>
          @endif
      </span>
    @include('customer.layouts.partials.sub-phone-categories', ['categories' => $category->children])

</section>
@endforeach
