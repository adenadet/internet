<template>
    <div v-show="isActive"><slot></slot>
        At least this should just show

        <div class="row" v-if="question.exam_type == 1">
            <div class="col-md-12 col-sm-12">
                <div class="form-group">
                    <label>Question</label>
                    <input type="text" class="form-control" name="question" id="question" v-model="question.question" />
                </div>
            </div>
        </div>
        <div class="row" v-if="questionData.exam_type == 1">
            <div class="col-md-12 col-sm-12">
                <div class="form-group">
                    <label>Question</label>
                    <input type="check" class="form-control" name="A" id="question" v-model="question.question" />
                </div>
            </div>
        </div>

        </div>
    </div>
</template>


<script>
export default{
    name: 'tab',
    props: {name:{required: true}, info:{}, selected: { default: false}},
    data(){
        return{
            isActive: false,
            
        }
    },
    created(){
        this.isActive = this.selected
    },
}
</script>

<style>
</style>