@extends('admin.layouts.master')

@section('head-tag')
<title>ایجاد نقش ادمین</title>
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">بخش کاربران</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">کاربران ادمین</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page"> ایجاد نقش ادمین</li>
    </ol>
</nav>


<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                    ایجاد نقش ادمین
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="{{ route('admin.user.admin-user.index') }}" class="btn btn-info btn-sm">بازگشت</a>
            </section>

            <section>
                <form action="{{ route('admin.user.admin-user.roles.store', $admin) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <section class="row">
                        <section class="col-12">
                            <div class="form-group">
                                <label for="tags">نقش ها</label>
                                <select multiple class="form-control form-control-sm" id="select_roles" name="roles[]">
                                    @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" @foreach ($admin->roles as $user_role)
                                        @if($user_role->id === $role->id)
                                        selected
                                        @endif
                                        @endforeach>{{ $role->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </section>
                        <section class="col-12">
                            <button class="btn btn-primary btn-sm">ثبت</button>
                        </section>
                    </section>
                </form>
            </section>

            <div class="flex space-x-2 mt-4 p-2">

                @if ($admin->roles)
                    @foreach ($admin->roles as $user_role)

                        <form class="px-4 py-2 bg-red-500 text-danger text-white rounded-md" method="POST"
                              action="{{ route('admin.user.admin-user.users.roles.remove', [$admin->id, $user_role->id]) }}"
                              onsubmit="return confirm('Are you sure to delete?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">{{ $user_role->name }}</button>
                        </form>

                    @endforeach
                @endif
            </div>

        </section>
    </section>
</section>

@endsection

@section('script')

<script>
    var select_roles = $('#select_roles');
    select_roles.select2({
        placeholder: 'لطفا نقش ها را وارد نمایید',
        multiple: true,
        tags : true
    })
</script>

@endsection
