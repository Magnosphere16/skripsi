<template>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item" :class="{'disabled':meta.current_page===1}">
                    <a class="page-link" href="#" @click.prevent="changePage(meta.current_page-1)"><i class="fas fa-arrow-left"></i></a>
                </li>
                <li class="page-item" :class="{'active':meta.current_page===p}" v-for="p in meta.last_page" :key="p">
                    <a class="page-link" href="#" @click.prevent="changePage(p)">{{p}}</a>
                </li>
                <li class="page-item" :class="{'disabled':meta.current_page===meta.last_page}">
                    <a class="page-link" href="#" @click.prevent="changePage(meta.current_page+1)"><i class="fas fa-arrow-right"></i></a>
                </li>
            </ul>
        </nav>
</template>

<script src="http://code.jquery.com/jquery-3.4.1.js"></script>
<script>

</script>

<script>
     export default {
        props: ['meta'],
        data(){
            return{
            }
        },
        methods:{
            changePage(page){
                this.$emit('pagination',page);
            },
        },
        created(){

        }

    }
</script>
