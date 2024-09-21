<button class="btn btn-danger delete-btn" data-id="{{ $id }}"><i class="fa fa-trash"></i> Delete</button>

<form id="delete-form-id-{{ $id }}" class="delete-form d-none" action="{{ $url }}" method="POST">
    @csrf
    @method('DELETE')
    <input type="hidden" name="id" value="{{ $id }}">
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.delete-btn').forEach(function (button) {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                var id = this.getAttribute('data-id');
                var form = document.getElementById('delete-form-id-' + id);

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
