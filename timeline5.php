<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://docs.dhtmlx.com/gantt/codebase/dhtmlxgantt.js?v=6.0.0"></script>
    <link rel="stylesheet" href="https://docs.dhtmlx.com/gantt/codebase/dhtmlxgantt.css?v=6.0.0">
</head>
<style>
    html,
    body {
        padding: 0px;
        margin: 0px;
        height: 100%;
    }

    #gantt_here {
        width: 100%;
        height: 800px;
        height: 100vh;
    }

    .gantt_grid_scale .gantt_grid_head_cell,
    .gantt_task .gantt_task_scale .gantt_scale_cell {
        font-weight: bold;
        font-size: 14px;
        color: rgba(0, 0, 0, 0.7);
    }

    .resource_marker {
        text-align: center;
    }

    .resource_marker div {
        width: 28px;
        height: 28px;
        line-height: 29px;
        display: inline-block;

        color: #FFF;
        margin: 3px;
    }

    .resource_marker.workday_ok div {
        border-radius: 15px;
        background: #51c185;
    }

    .resource_marker.workday_over div {
        border-radius: 3px;
        background: #ff8686;
    }

    .folder_row {
        font-weight: bold;
    }

    .gantt_task_cell.week_end {
        background-color: #e8e8e87d;
    }

    .gantt_task_row.gantt_selected .gantt_task_cell.week_end {
        background-color: #e8e8e87d !important;
    }


    .group_row,
    .group_row.odd,
    .gantt_task_row.group_row {
        background-color: rgba(232, 232, 232, 0.6);
    }

    .owner-label {
        width: 20px;
        height: 20px;
        line-height: 20px;
        font-size: 12px;
        display: inline-block;
        border: 1px solid #cccccc;
        border-radius: 25px;
        background: #e6e6e6;
        color: #6f6f6f;
        margin: 0 3px;
        font-weight: bold;
    }
</style>

<body>
    <div id="gantt_here" style="width:100%; height:100%;"></div>
</body>
<script>
    gantt.config.xml_date = "%Y-%m-%d %H:%i:%s";
    gantt.templates.grid_row_class = function(start, end, task) {
        var css = [];
        if (gantt.hasChild(task.id)) {
            css.push("folder_row");
        }

        if (task.$virtual) {
            css.push("group_row")
        }

        return css.join(" ");
    };

    gantt.templates.task_row_class = function(start, end, task) {
        return "";
    };

    gantt.templates.task_cell_class = function(task, date) {
        if (!gantt.isWorkTime({
                date: date,
                task: task
            }))
            return "week_end";
        return "";
    };

    gantt.templates.resource_cell_class = function(start_date, end_date, resource, tasks) {
        var css = [];
        css.push("resource_marker");
        if (tasks.length <= 1) {
            css.push("workday_ok");
        } else {
            css.push("workday_over");
        }
        return css.join(" ");
    };

    gantt.templates.resource_cell_value = function(start_date, end_date, resource, tasks) {
        var result = 0;
        tasks.forEach(function(item) {
            var assignments = gantt.getResourceAssignments(resource.id, item.id);
            assignments.forEach(function(assignment) {
                var task = gantt.getTask(assignment.task_id);
                if (resource.type == "work") {
                    if (task.shift_hrs) result += task.duration * assignment.value / task.shift_hrs;
                    else result += assignment.value * 1;
                } else {
                    result += assignment.value / (task.duration || 1);
                }
            });
        });

        if (result % 1) {
            result = Math.round(result * 10) / 10;
        }
        return "<div>" + result + "</div>";
    };



    var resourceTemplates = {
        grid_row_class: function(start, end, resource) {
            var css = [];
            if (gantt.$resourcesStore.hasChild(resource.id)) {
                css.push("folder_row");
                css.push("group_row");
            }

            return css.join(" ");
        },
        task_row_class: function(start, end, resource) {
            var css = [];

            if (gantt.$resourcesStore.hasChild(resource.id)) {
                css.push("group_row");
            }

            return css.join(" ");

        }
    };

    gantt.locale.labels.section_resources = "Resources";
    gantt.config.lightbox.sections = [{
            name: "description",
            height: 38,
            map_to: "text",
            type: "textarea",
            focus: true
        },
        {
            name: "resources",
            type: "resources",
            map_to: "resources",
            options: gantt.serverList("people")
        },
        {
            name: "time",
            type: "duration",
            map_to: "auto"
        }
    ];

    var resourceConfig = {
        scale_height: 30,
        subscales: [],
        columns: [{
                name: "name",
                label: "Name",
                tree: true,
                width: 250,
                template: function(resource) {
                    return resource.text;
                },
                resize: true
            },
            {
                name: "allocated",
                label: "Allocated",
                align: "left",
                width: 100,
                template: function(resource) {
                    var assignments = gantt.getResourceAssignments(resource.id);
                    var result = 0;
                    assignments.forEach(function(assignment) {
                        var task = gantt.getTask(assignment.task_id);
                        if (resource.type == "work") {
                            if (task.shift_hrs) result += task.duration * assignment.value / task.shift_hrs;
                            else result += task.duration * assignment.value;
                        } else {
                            result += assignment.value * 1;
                        }
                    });

                    if (resource.type == "work") {
                        result = "<b>" + result + "</b> hours";
                    } else {
                        result = "<b>" + result + "</b> " + resource.unit;
                    }

                    return result;
                },
                resize: true
            }
        ]
    };

    gantt.config.subscales = [{
        unit: "month",
        step: 1,
        date: "%F, %Y"
    }];

    gantt.config.auto_scheduling = true;
    gantt.config.auto_scheduling_strict = true;
    gantt.config.work_time = true;
    gantt.config.columns = [{
            name: "text",
            tree: true,
            width: 100,
            resize: true
        },
        {
            name: "start_date",
            align: "center",
            width: 80,
            resize: true
        },
        {
            name: "resources",
            align: "center",
            width: 80,
            label: "Resources",
            resize: true,
            template: function(task) {
                if (task.type == gantt.config.types.project) {
                    return "";
                }

                var result = "";
                var store = gantt.getDatastore("resource");
                var assignments = task[gantt.config.resource_property];

                if (!assignments || !assignments.length) {
                    return "";
                }

                if (assignments.length == 1) {
                    return store.getItem(assignments[0].resource_id).text.split(",")[0];
                }

                assignments.forEach(function(assignment) {
                    var resource = store.getItem(assignment.resource_id);
                    if (!resource)
                        return;
                    result += "<div class='owner-label' title='" + resource.text + "'>" + resource.text.substr(0, 1) + "</div>";

                });

                return result;
            }
        },
        {
            name: "duration",
            width: 60,
            align: "center",
            resize: true
        },
        {
            name: "add",
            width: 44
        }
    ];
    gantt.config.resource_store = "resource";
    gantt.config.resource_property = "resources";
    gantt.config.order_branch = true;
    gantt.config.open_tree_initially = true;
    gantt.config.scale_height = 50;
    gantt.config.layout = {
        css: "gantt_container",
        rows: [{
                gravity: 2,
                cols: [{
                        view: "grid",
                        group: "grids",
                        scrollY: "scrollVer"
                    },
                    {
                        resizer: true,
                        width: 1
                    },
                    {
                        view: "timeline",
                        scrollX: "scrollHor",
                        scrollY: "scrollVer"
                    },
                    {
                        view: "scrollbar",
                        id: "scrollVer",
                        group: "vertical"
                    }
                ]
            },
            {
                resizer: true,
                width: 1,
                next: "resources"
            },
            {
                height: 35,
                cols: [{
                        html: "",
                        group: "grids"
                    },
                    {
                        resizer: true,
                        width: 1
                    },
                    {
                        html: ""
                    }
                ]
            },

            {
                gravity: 1,
                id: "resources",
                config: resourceConfig,
                templates: resourceTemplates,
                cols: [{
                        view: "resourceGrid",
                        group: "grids",
                        scrollY: "resourceVScroll"
                    },
                    {
                        resizer: true,
                        width: 1
                    },
                    {
                        view: "resourceTimeline",
                        scrollX: "scrollHor",
                        scrollY: "resourceVScroll"
                    },
                    {
                        view: "scrollbar",
                        id: "resourceVScroll",
                        group: "vertical"
                    }
                ]
            },
            {
                view: "scrollbar",
                id: "scrollHor"
            }
        ]
    };

    gantt.$resourcesStore = gantt.createDatastore({
        name: gantt.config.resource_store,
        type: "treeDatastore",
        initItem: function(item) {
            item.parent = item.parent || gantt.config.root_id;
            item[gantt.config.resource_property] = item.parent;
            item.open = true;
            return item;
        }
    });


    gantt.$resourcesStore.attachEvent("onFilterItem", function(id, item) {
        return gantt.getResourceAssignments(id).length > 0;
    });

    //gantt.init("gantt_here");

    gantt.$resourcesStore.attachEvent("onParse", function() {
        var people = [];
        gantt.$resourcesStore.eachItem(function(res) {
            if (!gantt.$resourcesStore.hasChild(res.id)) {
                var copy = gantt.copy(res);
                copy.key = res.id;
                copy.label = res.text;
                people.push(copy);
            }
        });
        gantt.updateCollection("people", people);
    });
    gantt.attachEvent("onParse", function() {
        gantt.render();
    });
    gantt.$resourcesStore.parse([{
            id: 1,
            text: "Anna, Architect",
            unit: "hours/day",
            default_value: 8,
            type: "work"
        },
        {
            id: 2,
            text: "Finn, Construction worker",
            unit: "hours/day",
            default_value: 8,
            type: "work"
        },
        {
            id: 3,
            text: "Jake, Construction worker",
            unit: "hours/day",
            default_value: 8,
            type: "work"
        },
        {
            id: 4,
            text: "Floe, Plasterer",
            unit: "hours/day",
            default_value: 8,
            type: "work"
        },
        {
            id: 5,
            text: "Tom, Plumber",
            unit: "hours/day",
            default_value: 8,
            type: "work"
        },
        {
            id: 6,
            text: "Mike, Electrician",
            unit: "hours/day",
            default_value: 8,
            type: "work"
        },
        {
            id: 7,
            text: "Joe, Handyman",
            unit: "hours/day",
            default_value: 8,
            type: "work"
        },
        {
            id: 8,
            text: "Concrete",
            unit: "m3",
            default_value: 1
        },
        {
            id: 9,
            text: "Blocks",
            unit: "m3",
            default_value: 1
        },
        {
            id: 10,
            text: "Air conditioners",
            unit: "units",
            default_value: 1
        },
        {
            id: 11,
            text: "Radiators",
            unit: "units",
            default_value: 1
        },
        {
            id: 12,
            text: "Pipes",
            unit: "meters",
            default_value: 5
        },
        {
            id: 13,
            text: "Wires",
            unit: "meters",
            default_value: 10
        },
        {
            id: 14,
            text: "Paint",
            unit: "cans%",
            default_value: 1
        }

    ]);


    gantt.init("gantt_here");
    gantt.parse({
        "data": [{
                "id": "512",
                "start_date": "2018-09-23 00:00:00",
                "duration": 42,
                "text": "House Construction",
                "progress": "0",
                "type": "project",
                "parent": "0",
                "level": "0",
                "project_id": "51",
                "open": true,
                "end_date": "2018-11-21 00:00:00"
            },
            {
                "id": "513",
                "start_date": "2018-09-23 00:00:00",
                "duration": 4,
                "text": "Architectural design",
                "progress": "0",
                "type": "project",
                "parent": "512",
                "level": "1",
                "project_id": "51",
                "open": true,
                "end_date": "2018-09-28 00:00:00"
            },
            {
                "id": "514",
                "start_date": "2018-09-23 00:00:00",
                "duration": 2,
                "text": "Create a draft of architecture",
                "progress": "0",
                "type": "task",
                "parent": "513",
                "level": "2",
                "project_id": "51",
                "open": true,
                "end_date": "2018-09-26 00:00:00"
            },
            {
                "id": "515",
                "start_date": "2018-09-24 00:00:00",
                "duration": 2,
                "text": "Prepare construction documents",
                "progress": "0",
                "type": "task",
                "parent": "514",
                "level": "3",
                "project_id": "51",
                "shift_hrs": 20,
                "open": true,
                "end_date": "2018-09-26 00:00:00",
                "resources": [{
                    "resource_id": "1",
                    "value": "45"
                }]
            },
            {
                "id": "516",
                "start_date": "2018-09-26 00:00:00",
                "duration": 1,
                "text": "Agreement to architectural plan",
                "progress": "0",
                "type": "task",
                "parent": "513",
                "level": "2",
                "project_id": "51",
                "open": true,
                "end_date": "2018-09-27 00:00:00",
                "resources": [{
                    "resource_id": "1",
                    "value": "8"
                }]
            },
            {
                "id": "517",
                "start_date": "2018-09-27 00:00:00",
                "duration": 1,
                "text": "Agreement with client",
                "progress": "0",
                "type": "task",
                "parent": "513",
                "level": "2",
                "project_id": "51",
                "open": true,
                "end_date": "2018-09-28 00:00:00",
                "resources": [{
                    "resource_id": "1",
                    "value": "8"
                }]
            },
            {
                "id": "518",
                "start_date": "2018-09-28 00:00:00",
                "duration": 27,
                "text": "Construction Phase",
                "progress": "0",
                "type": "project",
                "parent": "512",
                "level": "1",
                "project_id": "51",
                "open": true,
                "end_date": "2018-11-06 00:00:00"
            },
            {
                "id": "519",
                "start_date": "2018-09-28 00:00:00",
                "duration": 5,
                "text": "Foundation",
                "progress": "0",
                "type": "project",
                "parent": "518",
                "level": "2",
                "project_id": "51",
                "open": true,
                "end_date": "2018-10-05 00:00:00"
            },
            {
                "id": "520",
                "start_date": "2018-09-28 00:00:00",
                "duration": 2,
                "text": "Excavation",
                "progress": "0",
                "type": "task",
                "parent": "519",
                "level": "3",
                "project_id": "51",
                "open": true,
                "end_date": "2018-10-02 00:00:00",
                "resources": [{
                    "resource_id": "2",
                    "value": "8"
                }]
            },
            {
                "id": "521",
                "start_date": "2018-10-02 00:00:00",
                "duration": 3,
                "text": "Pour concrete",
                "progress": "0",
                "type": "task",
                "parent": "519",
                "level": "3",
                "project_id": "51",
                "open": true,
                "end_date": "2018-10-05 00:00:00",
                "resources": [{
                        "resource_id": "3",
                        "value": "8"
                    },
                    {
                        "resource_id": "8",
                        "value": "15"
                    }
                ]
            },
            {
                "id": "522",
                "start_date": "2018-10-05 00:00:00",
                "duration": 5,
                "text": "Ground floor",
                "progress": "0",
                "type": "project",
                "parent": "518",
                "level": "2",
                "project_id": "51",
                "open": true,
                "end_date": "2018-10-12 00:00:00"
            },
            {
                "id": "523",
                "start_date": "2018-10-05 00:00:00",
                "duration": 1,
                "text": "Walls to 1st Floor",
                "progress": "0",
                "type": "task",
                "parent": "522",
                "level": "3",
                "project_id": "51",
                "open": true,
                "end_date": "2018-10-06 00:00:00",
                "resources": [{
                        "resource_id": "2",
                        "value": "8"
                    },
                    {
                        "resource_id": "9",
                        "value": "20"
                    }
                ]
            },
            {
                "id": "524",
                "start_date": "2018-10-08 00:00:00",
                "duration": 4,
                "text": "Roof structure",
                "progress": "0",
                "type": "task",
                "parent": "522",
                "level": "3",
                "project_id": "51",
                "open": true,
                "end_date": "2018-10-12 00:00:00",
                "resources": [{
                        "resource_id": "2",
                        "value": "8"
                    },
                    {
                        "resource_id": "9",
                        "value": "10"
                    }
                ]
            },
            {
                "id": "525",
                "start_date": "2018-10-12 00:00:00",
                "duration": 6,
                "text": "1st Floor",
                "progress": "0",
                "type": "project",
                "parent": "518",
                "level": "2",
                "project_id": "51",
                "open": true,
                "end_date": "2018-10-20 00:00:00"
            },
            {
                "id": "526",
                "start_date": "2018-10-12 00:00:00",
                "duration": 2,
                "text": "Walls to Terrace",
                "progress": "0",
                "type": "task",
                "parent": "525",
                "level": "3",
                "project_id": "51",
                "open": true,
                "end_date": "2018-10-16 00:00:00",
                "resources": [{
                        "resource_id": "3",
                        "value": "8"
                    },
                    {
                        "resource_id": "8",
                        "value": "10"
                    }
                ]
            },
            {
                "id": "527",
                "start_date": "2018-10-16 00:00:00",
                "duration": 4,
                "text": "Roof Structure",
                "progress": "0",
                "type": "task",
                "parent": "525",
                "level": "3",
                "project_id": "51",
                "open": true,
                "end_date": "2018-10-20 00:00:00",
                "resources": [{
                        "resource_id": "7",
                        "value": "8"
                    },
                    {
                        "resource_id": "8",
                        "value": "10"
                    }
                ]
            },
            {
                "id": "528",
                "start_date": "2018-10-20 00:00:00",
                "duration": 11,
                "text": "General works",
                "progress": "0",
                "type": "project",
                "parent": "518",
                "level": "2",
                "project_id": "51",
                "open": true,
                "end_date": "2018-11-06 00:00:00"
            },
            {
                "id": "529",
                "start_date": "2018-10-20 00:00:00",
                "duration": 1,
                "text": " Installation of air conditioning systems",
                "progress": "0",
                "type": "task",
                "parent": "528",
                "level": "3",
                "project_id": "51",
                "open": true,
                "end_date": "2018-10-23 00:00:00",
                "resources": [{
                        "resource_id": "6",
                        "value": "4"
                    },
                    {
                        "resource_id": "7",
                        "value": "8"
                    },
                    {
                        "resource_id": "10",
                        "value": "1"
                    }
                ]
            },
            {
                "id": "530",
                "start_date": "2018-10-21 00:00:00",
                "duration": 1,
                "text": "Installation of heating systems",
                "progress": "0",
                "type": "task",
                "parent": "528",
                "level": "3",
                "project_id": "51",
                "open": true,
                "end_date": "2018-10-23 00:00:00",
                "resources": [{
                        "resource_id": "7",
                        "value": "8"
                    },
                    {
                        "resource_id": "11",
                        "value": "3"
                    }
                ]
            },
            {
                "id": "531",
                "start_date": "2018-10-23 00:00:00",
                "duration": 5,
                "text": "Electricity installation",
                "progress": "0",
                "type": "task",
                "parent": "528",
                "level": "3",
                "project_id": "51",
                "open": true,
                "end_date": "2018-10-30 00:00:00",
                "resources": [{
                        "resource_id": "6",
                        "value": "8"
                    },
                    {
                        "resource_id": "13",
                        "value": "100"
                    }
                ]
            },
            {
                "id": "532",
                "start_date": "2018-10-30 00:00:00",
                "duration": 5,
                "text": "Waterworks and Plumbing",
                "progress": "0",
                "type": "task",
                "parent": "528",
                "level": "3",
                "project_id": "51",
                "open": true,
                "end_date": "2018-11-06 00:00:00",
                "resources": [{
                        "resource_id": "5",
                        "value": "8"
                    },
                    {
                        "resource_id": "12",
                        "value": "10"
                    }
                ]
            },
            {
                "id": "533",
                "start_date": "2018-11-06 00:00:00",
                "duration": 11,
                "text": "Decoration Phase",
                "progress": "0",
                "type": "project",
                "parent": "512",
                "level": "1",
                "project_id": "51",
                "open": true,
                "end_date": "2018-11-21 00:00:00"
            },
            {
                "id": "534",
                "start_date": "2018-11-06 00:00:00",
                "duration": 4,
                "text": "Walls",
                "progress": "0",
                "type": "task",
                "parent": "533",
                "level": "2",
                "project_id": "51",
                "open": true,
                "end_date": "2018-11-10 00:00:00"
            },
            {
                "id": "535",
                "start_date": "2018-11-09 00:00:00",
                "duration": 1,
                "text": "Ceilings",
                "progress": "0",
                "type": "task",
                "parent": "533",
                "level": "2",
                "project_id": "51",
                "open": true,
                "end_date": "2018-11-12 00:00:00"
            },
            {
                "id": "536",
                "start_date": "2018-11-11 00:00:00",
                "duration": 2,
                "text": "Floorings",
                "progress": "0",
                "type": "task",
                "parent": "533",
                "level": "2",
                "project_id": "51",
                "open": true,
                "end_date": "2018-11-14 00:00:00"
            },
            {
                "id": "537",
                "start_date": "2018-11-14 00:00:00",
                "duration": 3,
                "text": "Furniture ",
                "progress": "0",
                "type": "task",
                "parent": "533",
                "level": "2",
                "project_id": "51",
                "open": true,
                "end_date": "2018-11-17 00:00:00"
            },
            {
                "id": "538",
                "start_date": "2018-11-17 00:00:00",
                "duration": 2,
                "text": "Final Touches",
                "progress": "0",
                "type": "task",
                "parent": "533",
                "level": "2",
                "project_id": "51",
                "open": true,
                "end_date": "2018-11-21 00:00:00"
            },
            {
                "id": "539",
                "start_date": "2018-11-21 00:00:00",
                "duration": 0,
                "text": "Project submission",
                "progress": "0",
                "type": "milestone",
                "parent": "512",
                "level": "1",
                "project_id": "51",
                "open": true,
                "end_date": "2018-11-21 00:00:00"
            }
        ],
        "links": [{
                "id": "407",
                "source": "514",
                "target": "516",
                "type": "0",
                "project_id": "51"
            },
            {
                "id": "408",
                "source": "515",
                "target": "516",
                "type": "0",
                "project_id": "51"
            },
            {
                "id": "409",
                "source": "516",
                "target": "517",
                "type": "0",
                "project_id": "51"
            },
            {
                "id": "410",
                "source": "513",
                "target": "518",
                "type": "0",
                "project_id": "51"
            },
            {
                "id": "412",
                "source": "520",
                "target": "521",
                "type": "0",
                "project_id": "51"
            },
            {
                "id": "413",
                "source": "519",
                "target": "522",
                "type": "0",
                "project_id": "51"
            },
            {
                "id": "414",
                "source": "523",
                "target": "524",
                "type": "0",
                "project_id": "51"
            },
            {
                "id": "415",
                "source": "522",
                "target": "525",
                "type": "0",
                "project_id": "51"
            },
            {
                "id": "416",
                "source": "526",
                "target": "527",
                "type": "0",
                "project_id": "51"
            },
            {
                "id": "417",
                "source": "529",
                "target": "530",
                "type": "0",
                "project_id": "51"
            },
            {
                "id": "418",
                "source": "525",
                "target": "528",
                "type": "0",
                "project_id": "51"
            },
            {
                "id": "419",
                "source": "530",
                "target": "531",
                "type": "0",
                "project_id": "51"
            },
            {
                "id": "420",
                "source": "531",
                "target": "532",
                "type": "0",
                "project_id": "51"
            },
            {
                "id": "422",
                "source": "518",
                "target": "533",
                "type": "0",
                "project_id": "51"
            },
            {
                "id": "423",
                "source": "534",
                "target": "538",
                "type": "0",
                "project_id": "51"
            },
            {
                "id": "424",
                "source": "535",
                "target": "538",
                "type": "0",
                "project_id": "51"
            },
            {
                "id": "425",
                "source": "536",
                "target": "538",
                "type": "0",
                "project_id": "51"
            },
            {
                "id": "426",
                "source": "537",
                "target": "538",
                "type": "0",
                "project_id": "51"
            },
            {
                "id": "427",
                "source": "533",
                "target": "539",
                "type": "0",
                "project_id": "51"
            }
        ]
    });
</script>
<script>
    document.addEventListener('click',
        function() {
            const Olddata = gantt.serialize();
            let newdata = gantt.serialize();
            console.log(Olddata.data);
            console.log(newdata.data);
            console.log(Olddata.links);
        });
        const oldData = [
  { id: 1, name: 'Task 1', duration: 5 },
  { id: 2, name: 'Task 2', duration: 3 },
  // Additional tasks...
];

// New data
const newData = [
  { id: 1, name: 'Updated Task 1', duration: 7 },

  { id: 3, name: 'New Task', duration: 4 },
  { id: 4, name: 'New Task', duration: 6, number:100 },
  // Additional tasks...
];

// Merge old data with new data
const mergedData = oldData.map(oldItem => {
  const newItem = newData.find(newItem => newItem.id === oldItem.id);
  if (newItem) {
    const updatedItem = { ...oldItem };
    for (const prop in newItem) {
      if (newItem.hasOwnProperty(prop) && oldItem[prop] !== newItem[prop]) {
        updatedItem[porp] = newItem[prop];
      }
    }
    return updatedItem;
  }
  return oldItem;
});

// Add new items from newData to mergedData
newData.forEach(newItem => {
  const existingItem = mergedData.find(item => item.id === newItem.id);
  if (!existingItem) {
    mergedData.push(newItem);
  }
});

console.log(mergedData);
</script>

</html>