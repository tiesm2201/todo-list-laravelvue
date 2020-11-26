<template>
    <div>
        <form @submit="addTodo" enctype="multipart/form-data" class="center"> 
            <label for="name">Nieuwe taak toevoegen</label>
            <input class="textInput" type="text" v-model="name" ref="name" name="name" placeholder="Taak invoeren">            
            <input type="text" v-model="desc" ref="desc" name="desc" placeholder="Beschrijving invoeren">
            <br><br>
            <label class="label" for="file">Afbeelding toevoegen</label><br>
            <input type="file" ref="file" name="file" v-on:change="handleFileUpload">
            <br>
            <input type="submit" value="Taak toevoegen">
        </form>
    </div>
</template>

<script>
export default {
    name: "AddTodo",
    data() {
        return {
            title: '',
            desc: '',
            file: ''
        }
    },
    methods: {
        addTodo(e) {            
            e.preventDefault();            
            let newTodo = new FormData();
            newTodo.append('file', this.file);
            newTodo.append('name', this.name);
            newTodo.append('desc', this.desc);
            newTodo.append('done', 0);
            this.$emit('add-todo', newTodo);
            location.reload();
        },
        handleFileUpload(){
        this.file = this.$refs.file.files[0];

    }
  }
}
</script>

<style scoped>
.center {    
 display: flex;
 flex-direction: column;
 align-items: center;
}

.textInput {
    margin-top: 10px;
    margin-bottom: 10px;
}

.label {
    margin-top: 10px;
    margin-bottom: 10px;
}
</style>