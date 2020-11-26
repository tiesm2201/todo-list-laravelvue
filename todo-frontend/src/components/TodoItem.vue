<template>
    <div>
        <div v-bind:class="{'is-complete':todo.done}">
            <p>
                <input type="checkbox" v-on:change="markComplete">
                {{todo.name}}
                <button @click="$emit('show-details', todo.id)">Details</button>
                <button @click="$emit('edit-todo', todo.id)">Bewerken</button>
                <button @click="$emit('del-todo', todo.id)">x</button>
            </p>
            <div :id="todo.id" class="details">            
            <div>{{todo.desc}}</div>
            <img class="image" :src="'http://localhost:8000/storage/' + todo.file">
            </div>
            </div>
        
    </div>
</template>

<script>
import axios from "axios";
export default {
    name: "TodoItem",
    props: ["todo"],
    methods: {
        markComplete() {
            this.todo.done = !this.todo.done;
            axios.patch("http://localhost:8000/api/markcomplete", {"done": 1, "id": this.todo.id}).catch(error => {console.log(error.message)});
        },
        showDetails() {
            this.todo.showDetails = !this.todo.showDetails;
        }
    }
}
</script>

<style scoped>
    .is-complete {
        text-decoration: line-through;
    }
    .details {
        display: none;
    }
    .image {
        max-width: 1200px;
        width: 600px;
        object-fit: contain;
    }
</style>