import DashboardLayout from "./views/dashboardLayout";
import assessmentList from "./components/assessmentList";
import newAssessment from "./components/newAssessment";
import assessmentCard from "./components/assessmentCard";

export default [
  {
    path: "/assessment",
    component: DashboardLayout,
    children: [
        {
            path: "",
            name: "Assessments",
            component: assessmentList,
        },
        {
            path: "new-assessment",
            name: "New Assessment",
            component: newAssessment,
        },
        {
            path: "assessment-card/:id?",
            name: "Assessment Card",
            component: assessmentCard,
        },
    ],
  },
];
