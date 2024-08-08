<template>
    <div class="modal fade" id="journalShowInfoModal" tabindex="-1" role="dialog" aria-labelledby="journalShowInfoButton" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="journalShowInfoLabel">{{ content.title }}</h5>
                    <button ref="closeJournalShowInfo" type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group input-group-outline my-3">
                        <p>{{ content.text }}</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        data-bs-dismiss="modal"
                        aria-label="Close"
                        type="button"
                        class="btn bg-gradient-primary m-0">Ok</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ModalInfo",
    props: {
        content: {
            type: Object
        }
    }
}
</script>

<style scoped>

</style>
