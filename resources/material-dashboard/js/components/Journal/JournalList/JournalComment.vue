<template>
    <!-- Modal -->
    <div class="modal fade" id="journalComment" tabindex="-1" role="dialog" aria-labelledby="journalCommentLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-dark rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="journalCommentLabel">Комментарий:</h5>
                    <button ref="closeComments" type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group">
                        <textarea
                            :value="modelValue"
                            disabled
                            class="form-control text-white bg-transparent border" rows="7" spellcheck="false"
                        ></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: "JournalComment",
    props: {
        modelValue: String // раньше было `value: String`
    },
    data() {
        return {
        }
    }
}

</script>



<style scoped>

</style>
