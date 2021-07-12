<div class="modal fade" id="category_add_modal" tabindex="-1" role="dialog" aria-labelledby="category_add_modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="workerLabel">Add Color Palette</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class=""  method="POST" id="add_color_form">
                    @csrf
                    <div class="form-group">
                        <label>Color Palette Theme Name</label>
                        <input type="text" name="color_palette_name"  class="form-control" placeholder="Color Palette Theme Name" />
                        <span class="error-msg-input text-danger"></span>
                    </div>

                    <div class="form-group m-b-0">
                        <label>Theme Backgroud color</label>
                        <div data-color-format="hex" data-color="#1f74ad" class="colorpicker-default input-group colorpicker-element">
                            <input type="text" readonly="readonly" id="background_code" name="background_code" class="form-control" value="#1f74ad">
                            <div class="input-group-append add-on">
                                <button class="btn btn-white" type="button"><i style="background-color: rgb(214, 214, 214); margin-top: 2px;"></i>
                                </button>
                            </div>
                            <span class="error-msg-input text-danger"></span>
                        </div>
                    </div>

                    <div class="form-group m-b-0">
                        <label>Theme componet color</label>
                        <div data-color-format="hex" data-color="#b5808c" class="colorpicker-default input-group colorpicker-element">
                            <input type="text" readonly="readonly" id="components_code" name="components_code" class="form-control" value="#b5808c">
                            <div class="input-group-append add-on">
                                <button class="btn btn-white" type="button"><i style="background-color: rgb(214, 214, 214); margin-top: 2px;"></i>
                                </button>
                            </div>
                            <span class="error-msg-input text-danger"></span>
                        </div>
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
                <h5 class="modal-title" id="workerLabel">Edit Color Palette</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="" action="{{ route('admin.color.update') }}" method="POST" enctype="multipart/form-data" id="edit_category_form">
                    @csrf
                    <div class="form-group">
                        <label>Color Palette Theme Name</label>
                        <input type="text" name="color_palette_name" id="color_palette_name" class="form-control" placeholder="Color Palette Theme Name" />
                        <span class="error-msg-input text-danger"></span>
                    </div>

                    <div class="form-group m-b-0">
                        <label>Theme Backgroud color</label>
                        <div data-color-format="hex" data-color="#1f74ad" class="colorpicker-default input-group colorpicker-element">
                            <input type="text" readonly="readonly" id="background_code" name="background_code" class="form-control" value="#1f74ad">
                            <div class="input-group-append add-on">
                                <button class="btn btn-white" type="button"><i style="background-color: rgb(214, 214, 214); margin-top: 2px;"></i>
                                </button>
                            </div>
                            <span class="error-msg-input text-danger"></span>
                        </div>
                    </div>

                    <div class="form-group m-b-0">
                        <label>Theme componet color</label>
                        <div data-color-format="hex" data-color="#b5808c" class="colorpicker-default input-group colorpicker-element">
                            <input type="text" readonly="readonly" id="components_code" name="components_code" class="form-control" value="#b5808c">
                            <div class="input-group-append add-on">
                                <button class="btn btn-white" type="button"><i style="background-color: rgb(214, 214, 214); margin-top: 2px;"></i>
                                </button>
                            </div>
                            <span class="error-msg-input text-danger"></span>
                        </div>
                    </div>
                    <input type="hidden" id="color_id" name="id" value="">

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