@extends('layouts.app')
@section('title', 'Add New')
@section('content')

    <div class="container-fluid">
        <div class="d-flex justify-content-between py-4">
            <p class="page-title">Add New</p>
            <a class="btn btn-sm btn-warning" href="{{ route('food-waste.index') }}">View All</a>
        </div>
        <div class="card rounded-0">
            <div class="card-body">
                <div class="row">

               

                    <div class="col-md-12">
                        <form action="{{ route('food-waste.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Name *</label>
                                    <input type="text" class="form-control rounded-0" name="name" id="name"
                                        onkeyup="listingslug(this.value)" value="{{ old('name') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Slug *</label>
                                    <input type="text" readonly="readonly" class="form-control rounded-0" name="slug"
                                        id="slug" value="{{ old('slug') }}">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <input type="submit" class="btn btn-sm btn-success" value="Add New">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        function slugify(text) {
            return text
                .toString() // Cast to string
                .toLowerCase() // Convert the string to lowercase letters
                .normalize('NFD') // The normalize() method returns the Unicode Normalization Form of a given string.
                .trim() // Remove whitespace from both sides of a string
                .replace(/ /g, '-')
                .replace(/[^\w-]+/g, '') // Remove all non-word chars
                .replace(/\-\-+/g, '-'); // Replace multiple - with single -
        }

        function listingslug(text) {
            document.getElementById("slug").value = slugify(text);
        }

    </script>
    <script type="text/javascript">
</script>
@endpush

