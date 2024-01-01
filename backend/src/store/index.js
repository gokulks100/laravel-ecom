import {createStore} from "vuex";

const store = createStore({
    state:{
        user:{
            token:"234",
            data:{
                id:1,
                name:"gokul"
            }
        }
    },
    getters:{},
    actions:{},
    mutations:{}
})


export default store
