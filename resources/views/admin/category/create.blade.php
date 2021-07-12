<div class="modal fade" id="category_add_modal" tabindex="-1" role="dialog" aria-labelledby="category_add_modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="workerLabel">Add Interest Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="" action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data" id="add_category_form">
                    @csrf
                    <div class="form-group">
                        <label>Interest Category Name</label>
                        <input type="text" name="interest_category_name" class="form-control" placeholder="Enter category name" />
                        <span class="error-msg-input text-danger"></span>
                    </div>

                    <div class="form-group float-right">
                        <div>
                            <button type="submit" class="btn btn-success waves-effect waves-light">
                                Submit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="category_edit_modal" tabindex="-1" role="dialog" aria-labelledby="category_edit_modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="workerLabel">Edit Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="" action="{{ route('admin.category.update') }}" method="POST" enctype="multipart/form-data" id="edit_category_form">
                    @csrf
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" id="interest_category_name" name="interest_category_name" class="form-control" placeholder="Enter category name.." />
                        <span class="error-msg-input text-danger"></span>
                    </div>

                    <input type="hidden" id="category_id" name="id" value="">

                    <div class="form-group float-right">
                        <div>
                            <button type="submit" class="btn btn-success waves-effect waves-light">
                                Update
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>