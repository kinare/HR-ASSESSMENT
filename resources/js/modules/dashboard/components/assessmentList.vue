<template>
    <v-container>
        <v-row>
            <v-col cols="12" offset-md="3" md="6">
                <v-card>
                    <v-card-title>
                        Assessments

                        <v-spacer />

                        <v-btn color="primary" small :to="{ name: 'New Assessment'}">
                            Take Assessment
                        </v-btn>
                    </v-card-title>

                    <v-divider />
                    <v-card-text>
                        <v-list>
                            <v-list-item-group>
                                <v-list-item v-for="(assessment, i) in assessments" :key="i">
                                    <v-list-item-avatar>{{ i + 1 }}</v-list-item-avatar>
                                    <v-list-item-content>
                                        <v-list-item-title>{{ assessment.assessment_date }} ({{ assessment.policy_documents.length }} Recommended Documents)</v-list-item-title>
                                        <v-list-item-subtitle>

                                            <v-chip-group>
                                                <v-chip small color="primary">Questions: {{ assessment.questions.length }}</v-chip>
                                                <v-chip small color="success">Pass: {{ assessment.questions.filter( q => q.status === 'pass').length }}</v-chip>
                                                <v-chip small color="error">Failed: {{ assessment.questions.filter( q => q.status === 'fail').length }}</v-chip>
                                            </v-chip-group>

                                        </v-list-item-subtitle>
                                    </v-list-item-content>
                                    <v-list-item-action>
                                        <v-btn small icon @click="select(assessment)">
                                            <v-icon>mdi-eye</v-icon>
                                        </v-btn>
                                    </v-list-item-action>
                                </v-list-item>
                            </v-list-item-group>
                        </v-list>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>

        <v-dialog v-model="dialog" width="600" v-if="selected">
            <v-card>
                <v-card-title>
                    Results and Recommendations
                </v-card-title>

                <v-divider />

                <v-tabs v-model="tabs" grow>
                    <v-tab>Result</v-tab>
                    <v-tab>Recommended Documents</v-tab>
                </v-tabs>

                <v-tabs-items v-model="tabs">
                    <v-tab-item>
                        <v-card-text>
                            <v-chip-group>
                                <v-chip small color="primary">Questions: {{ selected.questions.length }}</v-chip>
                                <v-chip small color="success">Pass: {{ selected.questions.filter( q => q.status === 'pass').length }}</v-chip>
                                <v-chip small color="error">Failed: {{ selected.questions.filter( q => q.status === 'fail').length }}</v-chip>
                            </v-chip-group>

                            <v-divider />

                            <v-list>
                                <v-list-item v-for="(question, i) in selected.questions" :key="i">
                                    <v-list-item-avatar>{{ i + 1 }}</v-list-item-avatar>
                                    <v-list-item-content>
                                        <v-list-item-title>{{ question.policy_question.question}}</v-list-item-title>
                                        <v-list-item-subtitle class="caption">{{ question.scale.description }}</v-list-item-subtitle>
                                    </v-list-item-content>
                                    <v-list-item-icon>
                                        <v-icon :color="question.status === 'pass' ? 'success' : 'error'">
                                            {{ `mdi-${question.status === 'pass' ? 'check' : 'cancel'}`}}
                                        </v-icon>
                                    </v-list-item-icon>
                                </v-list-item>
                            </v-list>
                        </v-card-text>
                    </v-tab-item>
                    <v-tab-item>
                        <v-card-subtitle v-for="(doc, j) in selected.policy_documents" :key="j">
                            <h4 class="text-h5">{{ doc.policy.topic }}</h4>
                            {{ doc.Description }}
                        </v-card-subtitle>
                    </v-tab-item>
                </v-tabs-items>

                <v-divider />

                <v-card-actions>
                    <v-spacer />
                    <v-btn text @click="dialog = false">
                        Close
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>
</template>

<script>
export default {
    name: "assessmentList",

    data: function (){
        return {
            dialog : false,
            tabs : null,
            selected: null
        }
    },

    beforeCreate() {
        this.$store.dispatch('Dashboard/getAssessments')
    },

    computed: {
        assessments(){
            return this.$store.getters['Dashboard/assessments']
        }
    },

    methods: {
        select: function (item){
            this.selected = item;
            this.dialog = true;
        }
    }
}
</script>

<style scoped>

</style>
