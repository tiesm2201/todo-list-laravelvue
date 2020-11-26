<template>
  <div id="app">
    <Header class="header" />
    <div class="container">
    <AddTodo v-on:add-todo="addTodo" class="addTodo" />
    <Todos v-bind:todos="todos" v-on:del-todo="deleteTodo" v-on:edit-todo="editTodo" v-on:show-details="showDetails" class="todos" />
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Header from './components/layout/Header';
import Todos from './components/Todos';
import AddTodo from './components/AddTodo';

export default {
  created() {
    axios.get("http://127.0.0.1:8000/api/get")
    .then(res => this.todos = res.data)
    .catch(error => console.log("Kon de takenlijkst niet ophalen: " + error.message));
  },
  name: 'App',
  components: {
    Header,
    Todos,
    AddTodo,
  },
  data() {
    return {
      todos: []
    }
  },
methods: {
  deleteTodo(id) {
    this.todos = this.todos.filter(todo => todo.id !== id);
    console.log(id);
    axios.delete(`http://127.0.0.1:8000/api/delete/${id}`, {"id": id}).catch(error => {
      console.log("Kon de taak niet verwijderen: " + error.message);
    });
  },
  editTodo(id) {
    let newName = prompt("Nieuwe naam van de taak: (als er niets ingevuld is blijft de naam onveranderd)");
    let newDesc = prompt("Nieuwe beschrijving: (als er niets is ingevuld blijft de beschrijving onveranderd)")
    axios.patch("http://127.0.0.1:8000/api/update", {"id": id , "name": `${newName}`,
    "desc": `${newDesc}`} )
    .then(() => {
      location.reload();
    })
    .catch(error => {
      console.log("Kon de taak niet veranderen: " + error.message);
    });
  },
  showDetails(id) {
    let el = document.getElementById(`${id}`);
    if(el.style.display == "block") {
      el.style.display = "none";
    } else {      
      el.style.display = "block";
    }    
  },
  addTodo(newTodo) {
    axios.post("http://127.0.0.1:8000/api/create", newTodo, {
      headers: { 
        'Content-Type': 'multipart/form-data'
      }
     })
     .then(() => {
    this.todos = [...this.todos, newTodo];
     })
     .catch(error => {
        console.log("Kon de taak niet toevoegen: " + error.message);
      });      
  }
}
}
</script>

<style>
#app {
  font-family: sans-serif;
}
.header {
  text-align: center;
}

.container {
  width: 100%;
  height: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
}
.addTodo {
 width: 300px;
}

.todos {
 width: 1200px;
 display: flex;
 flex-direction: column;
 align-items: center;
}
</style>
