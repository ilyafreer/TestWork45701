<template>
    <div class="col-6">
        <form>
            <div class="form-group">
                <label for="professionName">Профессия</label>
                <input type="text" class="form-control" id="professionName" v-model="form.profession"
                       placeholder="Название професии">
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="isPublished" v-model="form.published">
                <label class="form-check-label" for="isPublished">Опубликовать</label>
            </div>
            <button type="button" @click="save" class="btn btn-primary">Сохранить</button>
        </form>
    </div>
</template>

<script>
export default {
    data: () => ({
        form: {
            id:null,
            profession: '',
            published: false
        },
    }),
    mounted() {
    },
    methods: {
        async save() {
            let url = '/profession'
            url += this.form.id > 0  ? '/'+this.form.id : ''

            const response = await fetch(url, {
                method: this.form.id > 0  ? 'PUT':'POST',
                headers: {
                    'Content-Type': 'application/json;charset=utf-8',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify(this.form)
            })

            const result = await response.json()
            if(result.status){
                console.log('ok')
                this.$root.$children.find(child => { return child.$options.name === "profession-list" }).loadAllProfessions()
            }
        }
    }
}
</script>
