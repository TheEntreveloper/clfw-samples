</main>
<!-- terms -->
<div class="modal fade bg-body-secondary p-4 py-md-5" tabindex="-1" aria-hidden="true" role="dialog" id="termsModal">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header border-bottom-0">
                <h1 class="modal-title fs-5" id="termstitle">Terms of use & Disclaimer</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-0">
                <div id="termscnt">
                    &nbsp;
                </div>
            </div>
            <div class="modal-footer flex-column align-items-stretch w-100 gap-2 pb-3 border-top-0">
                <button type="button" class="btn btn-lg btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<footer class="footer mt-auto py-3 bg-body-tertiary">
    <div class="container">
        <span class="text-body-secondary">A Codelib Framework Sample. (C) Copyright Codelib Framework. Released under the MIT License</span>
    </div>
</footer>
<script src="lookandfeel/assets/bootstrap532/js/bootstrap.min.js"></script>
<script>
    function showTerms(url, title) {
        if (title === undefined) {
            title = 'Terms of use & Disclaimer';
        }
        $('#termstitle').html(title);
        $('#termscnt').load(url);
        $('#termsModal').modal('show');
    }
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
</script>
</body>
</html>
