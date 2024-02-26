<button type="submit" class="action-create-button" onclick="showSpinner()">
    <span id="spinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
    Update
</button>

<script>
   function showSpinner(){
        $('#spinner').show();
        // $('#create-button').text('updating...');
    }
</script>