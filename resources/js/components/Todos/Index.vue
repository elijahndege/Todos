

<template>
  <div class="page-content page-container" id="page-content">
    <div class="padding">
      <div class="row container d-flex justify-content-center">
        <div class="col-lg-12">
          <div class="card px-3">
            <div class="card-body">
              <h4 class="card-title">Todo list</h4>
              <div class="add-items d-flex">
                <input
                  @keyup.enter="addTask"
                  v-model="newTask"
                  type="text"
                  class="form-control todo-list-input"
                  placeholder="What do you need to do today?"
                />
                <button
                  @click="addTask"
                  :disabled="newTask.length === 0"
                  class="add btn btn-primary font-weight-bold todo-list-add-btn"
                >Add</button>
              </div>
              <div class="list-wrapper">
                <ul class="d-flex flex-column-reverse todo-list">
                  <li v-for="(task, index) in tasks" :key="index">
                    <div
                      class="form-check"
                      @click="updateTask(task)"
                      :class="{completed: task.is_completed}"
                    >
                      <label class="form-check-label">
                        <input class="checkbox" type="checkbox" v-model="task.is_completed" />
                        {{task.task}}
                        <i class="input-helper"></i>
                      </label>
                    </div>
                    <i @click.prevent="destroy(task)" class="remove fa fa-trash"></i>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
export default {
  mounted() {
    this.fetchTodos();
  },
  data() {
    return {
      isLoading: true,
      isEditing: false,
      newTask: "",
      tasks: [],
      validation: []
    };
  },
  methods: {
    async fetchTodos() {
      try {
        this.tasks = (
          await this.axios.get("/api/todos")
        ).data.data;
        console.log(this.tasks);
      } catch (e) {
        console.log(e);
        alert(e.error);
      }
      this.isLoading = false;
    },
    updateTask(task) {
      console.log(task);
      task.is_completed = !task.is_completed;
      let uri = `/api/todos/update/${task.id}`;

      this.axios
        .patch(uri, { task: task.task, is_completed: task.is_completed })
        .then(response => {
          this.tasks.splice(task.index, 1, response.data.data);
        });
    },
    addTask() {
      if (this.newTask.length > 0) {
        let task = {
          task: this.newTask,
          is_completed: false
        };
        let uri = "/api/todos/store";
        this.axios
          .post(uri, task)
          .then(response => {
            this.tasks.push(response.data.data);
            this.newTask = "";
          })
          .catch(error => {
            this.validation = error.response.data.data;
          });
      }
    },
    destroy(task) {
      let uri = `/api/todos/${task.id}`;
      this.axios
        .delete(uri)
        .then(response => {
          this.tasks.splice(task.index, 1);
          // this.tasks = this.tasks.filter(task => task.id !== id);
        })
        .catch(error => {
          alert("system error!");
        });
    }
  }
};
</script>