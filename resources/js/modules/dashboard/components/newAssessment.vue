<template>
    <v-container>
        <v-row>
            <v-col cols="12" offset-md="2" md="8">
                <v-card>

                    <v-toolbar flat>
                        <v-toolbar-title> Assessment Questions</v-toolbar-title>
                    </v-toolbar>

                    <v-divider />

                    <v-tabs grow v-model="tab" show-arrows>
                        <v-tab :disabled="question.status !== ''" v-for="(question, i) in questions" :key="i">
                            Question {{ i + 1 }}
                        </v-tab>

                        <v-tabs-items v-model="tab">
                            <v-tab-item  v-for="(question, i) in questions" :key="i">
                                <v-card flat class="mb-12">
                                    <v-card-subtitle>TOPIC: {{ question.topic }}</v-card-subtitle>

                                    <v-card-title>

                                        {{ question.question }}

                                        <v-spacer />

                                        Time {{ time_taken }}/ {{ question.time_allocated }}

                                    </v-card-title>

                                    <v-card-text>
                                        <v-radio-group class="ml-5">
                                            <v-radio @change="question.status = option.correct ? 'pass' : 'fail'" v-for="(option, n) in question.options" :key="n" :label="option.option" :value="option.id"/>
                                        </v-radio-group>
                                    </v-card-text>

                                    <v-card-actions>
                                        <v-spacer />
                                        <v-btn color="primary" @click="submit(question)" v-if="tab === questions.length - 1">
                                            Submit
                                        </v-btn>

                                        <v-btn color="primary" @click="next(question)" v-else>
                                            Continue
                                        </v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-tab-item>
                        </v-tabs-items>

                    </v-tabs>


                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    name: "newAssessment",
    data: function (){
        return {
            tab: null,
            time_taken: 0,
            questions: []
        }
    },

    mounted() {
        setInterval(() => {
            this.time_taken +=1
        }, 1000)

        Event.$on('submitted', () => {
            this.$router.push({name: "Assessments"})
        })
    },

    beforeRouteEnter(to, from, next){
        next( v=>{
            v.$store.dispatch('Dashboard/getPolicies')
        })
    },

    computed: {
        policies(){
            return this.$store.getters['Dashboard/policies'];
        },
    },

    methods: {
        next: function( item ){
            this.tab++
            item.time_taken = this.time_taken;
            this.time_taken = 0
        },

        submit: function (item){
            item.time_taken = this.time_taken;
            this.time_taken = 0
            this.$store.dispatch('Dashboard/submitAssessment', { ...this.questions });
        }
    },

    watch: {
        policies: {
            handler: function (policies){
                this.questions = [];

                policies.forEach( policy => {
                    policy.questions.forEach( quiz => {
                        this.questions.push({
                            policy_question_id : quiz.id,
                            status : "",
                            time_allocated : quiz.time_allocated,
                            time_taken :0,
                            options : quiz.options,
                            topic : policy.topic,
                            question : quiz.question,
                        })
                    })
                })
            },
            immediate: true
        }
    }
}
</script>

<style scoped>

</style>
