<form id="uploadResForm" method="POST" action="/files" enctype="multipart/form-data" style="display:none;">
    {!! csrf_field() !!}
    <input type="file" name="file" onchange="submitUploadResForm()"/>
</form>