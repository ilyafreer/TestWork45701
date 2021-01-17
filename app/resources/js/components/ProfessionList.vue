<template>
    <div class="col-6">
        <div class="spinner-border text-danger" role="status" v-if="loading">
            <span class="sr-only">Loading...</span>
        </div>
        <div class="list-group" v-if="professions">
            <div class="list-group-item list-group-item-action active" v-for="item in professions">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1" @click="updateProfession(item)">{{ item.profession }} <i class="cursor-pointer fa fa-pencil"></i></h5>
                    <small class="cursor-pointer" @click="deleteProfession(item.id)"><i class="cursor-pointer fa fa-trash"></i></small>
                </div>
                <small v-if="item.published">Опубликовано</small>
                <small v-else>Не опубликовано</small>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: () => ({
        professions: null,
        loading: true
    }),
    mounted() {
        this.loadAllProfessions();
    },
    methods: {
        updateProfession(item) {
            const professionCreate = this.$root.$children.find(child => {
                return child.$options.name === "profession-create"
            })
            professionCreate.form.profession = item.profession
            professionCreate.form.published = item.published
            professionCreate.form.id = item.id
        },
        async loadAllProfessions() {
            this.loading = true
            const response = await fetch('/profession', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            this.professions = await response.json()
            this.loading = false
        },
        async deleteProfession(id) {
            this.loading = true
            const response = await fetch('/profession/' + id, {
                method: 'DELETE',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json;charset=utf-8',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })

            const result = await response.json()
            this.loading = false
            if (result.status) {
                for (let key in this.professions) {
                    if (this.professions[key].id === id)
                        this.professions.splice(key, 1);
                }
            } else {
                console.log('Произошла ошибка при удалении')
            }
        }
    }
}
</script>
