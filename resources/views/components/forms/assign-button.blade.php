<button id="assign-button" type="submit" class="action-create-button" onclick="showSpinner()">
    <span id="spinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
    Assign
</button>


<script>
   function showSpinner(){
        $('#spinner').show();
        // $('#assign-button').text('assining...');
    }
</script>