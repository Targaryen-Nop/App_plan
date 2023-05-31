<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://docs.dhtmlx.com/gantt/codebase/dhtmlxgantt.js?v=6.0.0"></script>
    <link rel="stylesheet" href="https://docs.dhtmlx.com/gantt/codebase/dhtmlxgantt.css?v=6.0.0">
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
            height: calc(100vh - 52px);
        }

        .gantt_grid_scale .gantt_grid_head_cell,
        .gantt_task .gantt_task_scale .gantt_scale_cell {
            font-weight: bold;
            font-size: 14px;
            color: rgba(0, 0, 0, 0.7);
        }

        .folder_row {
            font-weight: bold;
        }

        .highlighted_resource,
        .highlighted_resource.odd {
            background-color: rgba(255, 251, 224, 0.6);
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


        .resource-select-panel .gantt_layout_content {
            line-height: 35px;
            text-align: right;
            padding-right: 15px;
            overflow: hidden !important;
        }

        .resource-select {
            padding: 3px;
            margin-left: 13px;
        }

        .column_overload .gantt_histogram_fill {
            background-color: #ffa9a9;
        }
    </style>
</head>

<body>
    <div id="gantt_here" style="width:100%; height:100%;"></div>
</body>
<script>
    var dates = [{
            date: new Date(2019, 03, 02),
            value: 12
        },
        {
            date: new Date(2019, 03, 03),
            value: 17
        },
        {
            date: new Date(2019, 03, 04),
            value: 32
        },
        {
            date: new Date(2019, 03, 05),
            value: 62
        },
        {
            date: new Date(2019, 03, 06),
            value: 22
        },
    ]

    var UNASSIGNED_ID = 5;
    var WORK_DAY = 8;

    gantt.templates.timeline_cell_class = function(task, date) {
        if (!gantt.isWorkTime({
                date: date,
                task: task
            }))
            return "week_end";
        return "";
    };

    function getAllocatedValue(tasks, resource) {
        var result = 0;
        tasks.forEach(function(item) {
            var assignments = gantt.getResourceAssignments(resource.id, item.id);
            assignments.forEach(function(assignment) {
                result += Number(assignment.value);
            });
        });
        return result;
    }
    var cap = {};

    function getCapacity(date, resource) {
        /* it is sample function your could to define your own function for get Capability of resources in day */
        if (gantt.$resourcesStore.hasChild(resource.id)) {
            return -1;
        }

        var val = date.valueOf();
        if (!cap[val + resource.id]) {
            cap[val + resource.id] = [0, 1, 2, 3][Math.floor(Math.random() * 100) % 4];
        }
        return cap[val + resource.id] * WORK_DAY;
    }

    gantt.templates.histogram_cell_class = function(start_date, end_date, resource, tasks) {
        if (getAllocatedValue(tasks, resource) > getCapacity(start_date, resource)) {
            return "column_overload"
        }
    };

    gantt.templates.histogram_cell_label = function(start_date, end_date, resource, tasks) {
        if (tasks.length && !gantt.$resourcesStore.hasChild(resource.id)) {
            for (var i = 0; i < dates.length; i++) {
                if (+start_date == +dates[i].date) return dates[i].value
            }

            return getAllocatedValue(tasks, resource) + "/" + getCapacity(start_date, resource);
        } else {
            if (!gantt.$resourcesStore.hasChild(resource.id)) {
                return '&ndash;';
            }
            return '';
        }
    };
    gantt.templates.histogram_cell_allocated = function(start_date, end_date, resource, tasks) {
        return getAllocatedValue(tasks, resource);
    };

    gantt.templates.histogram_cell_capacity = function(start_date, end_date, resource, tasks) {
        if (!gantt.isWorkTime(start_date)) {
            return 0;
        }
        return getCapacity(start_date, resource);
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

    gantt.locale.labels.section_owner = "Owner";
    gantt.config.lightbox.sections = [{
            name: "description",
            height: 38,
            map_to: "text",
            type: "textarea",
            focus: true
        },
        {
            name: "owner",
            type: "resources",
            map_to: "owner",
            options: gantt.serverList("people"),
            default_value: WORK_DAY,
            unassigned_value: UNASSIGNED_ID
        },
        {
            name: "time",
            type: "duration",
            map_to: "auto"
        }
    ];
    gantt.config.resource_render_empty_cells = true;

    function getResourceAssignments(resourceId) {
        var assignments;
        var store = gantt.getDatastore(gantt.config.resource_store);
        if (store.hasChild(resourceId)) {
            assignments = [];
            store.getChildren(resourceId).forEach(function(childId) {
                assignments = assignments.concat(gantt.getResourceAssignments(childId));
            });
        } else {
            assignments = gantt.getResourceAssignments(resourceId);
        }
        return assignments;
    }

    var resourceConfig = {
        scale_height: 30,
        row_height: 45,
        scales: [{
            unit: "day",
            step: 1,
            date: "%d %M"
        }],
        columns: [{
                name: "name",
                label: "Name",
                tree: true,
                width: 200,
                template: function(resource) {
                    return resource.text;
                },
                resize: true
            },
            {
                name: "progress",
                label: "Complete",
                align: "center",
                template: function(resource) {
                    var store = gantt.getDatastore(gantt.config.resource_store);
                    var totalToDo = 0,
                        totalDone = 0;

                    var assignments = getResourceAssignments(resource.id);

                    assignments.forEach(function(assignment) {
                        var task = gantt.getTask(assignment.task_id);
                        totalToDo += task.duration;
                        totalDone += task.duration * (task.progress || 0);
                    });

                    var completion = 0;
                    if (totalToDo) {
                        completion = (totalDone / totalToDo) * 100;
                    }

                    return Math.floor(completion) + "%";
                },
                resize: true
            },
            {
                name: "workload",
                label: "Workload",
                align: "center",
                template: function(resource) {

                    var totalDuration = 0;

                    var assignments = getResourceAssignments(resource.id);
                    assignments.forEach(function(assignment) {
                        var task = gantt.getTask(assignment.task_id);
                        totalDuration += Number(assignment.value) * task.duration;
                    });

                    return (totalDuration || 0) + "h";

                },
                resize: true
            },

            {
                name: "capacity",
                label: "Capacity",
                align: "center",
                template: function(resource) {
                    var store = gantt.getDatastore(gantt.config.resource_store);
                    var n = store.hasChild(resource.id) ? store.getChildren(resource.id).length : 1

                    var state = gantt.getState();

                    return gantt.calculateDuration(state.min_date, state.max_date) * n * WORK_DAY + "h";
                }
            }

        ]
    };

    gantt.config.scales = [{
            unit: "month",
            step: 1,
            format: "%F, %Y"
        },
        {
            unit: "day",
            step: 1,
            format: "%d %M"
        }
    ];

    gantt.config.columns = [{
            name: "text",
            tree: true,
            width: 200,
            resize: true
        },
        {
            name: "start_date",
            align: "center",
            width: 80,
            resize: true
        },
        {
            name: "owner",
            align: "center",
            width: 80,
            label: "Owner",
            template: function(task) {
                if (task.type == gantt.config.types.project) {
                    return "";
                }

                var store = gantt.getDatastore("resource");
                var assignments = task[gantt.config.resource_property];

                if (!assignments || !assignments.length) {
                    return "Unassigned";
                }

                if (assignments.length == 1) {
                    return store.getItem(assignments[0].resource_id).text;
                }

                var result = "";
                assignments.forEach(function(assignment) {
                    var owner = store.getItem(assignment.resource_id);
                    if (!owner)
                        return;
                    result += "<div class='owner-label' title='" + owner.text + "'>" + owner.text.substr(0, 1) + "</div>";

                });

                return result;
            },
            resize: true
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
    gantt.config.resource_property = "owner";
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
                        html: "<label>Resource<select class='resource-select'></select>",
                        css: "resource-select-panel",
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
                        view: "resourceHistogram",
                        capacity: 24,
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



    gantt.attachEvent("onTaskLoading", function(task) {
        var ownerValue = task[gantt.config.resource_property];

        if (!task.$virtual && (!ownerValue || !Array.isArray(ownerValue) || !ownerValue.length)) {
            task[gantt.config.resource_property] = [{
                resource_id: 5,
                value: 0
            }]; //'Unassigned' group
        }
        return true;
    });

    gantt.$resourcesStore.attachEvent("onParse", function() {
        var people = [];

        gantt.$resourcesStore.eachItem(function(res) {
            if (!gantt.$resourcesStore.hasChild(res.id)) {
                var copy = gantt.copy(res);
                copy.key = res.id;
                copy.label = res.text;
                copy.unit = "hours";
                people.push(copy);
            }
        });
        gantt.updateCollection("people", people);
    });

    gantt.$resourcesStore.parse([{
            id: 1,
            text: "QA",
            parent: null
        },
        {
            id: 2,
            text: "Development",
            parent: null
        },
        {
            id: 3,
            text: "Sales",
            parent: null
        },
        {
            id: 4,
            text: "Other",
            parent: null
        },
        {
            id: 5,
            text: "Unassigned",
            parent: 4,
            default: true
        },
        {
            id: 6,
            text: "John",
            parent: 1
        },
        {
            id: 7,
            text: "Mike",
            parent: 2
        },
        {
            id: 8,
            text: "Anna",
            parent: 2
        },
        {
            id: 9,
            text: "Bill",
            parent: 3
        },
        {
            id: 10,
            text: "Floe",
            parent: 3
        }
    ]);

    gantt.init("gantt_here");
    gantt.parse({
        "data": [{
                "id": 1,
                "text": "Office itinerancy",
                "type": "project",
                "start_date": "02-04-2019 00:00",
                "duration": 17,
                "progress": 0.4,
                "owner": [{
                    "resource_id": "5",
                    "value": 3
                }],
                "parent": 0
            },
            {
                "id": 2,
                "text": "Office facing",
                "type": "project",
                "start_date": "02-04-2019 00:00",
                "duration": 8,
                "progress": 0.6,
                "owner": [{
                    "resource_id": "5",
                    "value": 4
                }],
                "parent": "1"
            },
            {
                "id": 3,
                "text": "Furniture installation",
                "type": "project",
                "start_date": "11-04-2019 00:00",
                "duration": 8,
                "parent": "1",
                "progress": 0.6,
                "owner": [{
                    "resource_id": "5",
                    "value": 2
                }]
            },
            {
                "id": 4,
                "text": "The employee relocation",
                "type": "project",
                "start_date": "13-04-2019 00:00",
                "duration": 5,
                "parent": "1",
                "progress": 0.5,
                "owner": [{
                    "resource_id": "5",
                    "value": 4
                }],
                "priority": 3
            },
            {
                "id": 5,
                "text": "Interior office",
                "type": "task",
                "start_date": "03-04-2019 00:00",
                "duration": 7,
                "parent": "2",
                "progress": 0.6,
                "owner": [{
                    "resource_id": "6",
                    "value": 5
                }],
                "priority": 1
            },
            {
                "id": 6,
                "text": "Air conditioners check",
                "type": "task",
                "start_date": "03-04-2019 00:00",
                "duration": 7,
                "parent": "2",
                "progress": 0.6,
                "owner": [{
                    "resource_id": "7",
                    "value": 1
                }],
                "priority": 2
            },
            {
                "id": 7,
                "text": "Workplaces preparation",
                "type": "task",
                "start_date": "12-04-2019 00:00",
                "duration": 8,
                "parent": "3",
                "progress": 0.6,
                "owner": [{
                    "resource_id": "10",
                    "value": 2
                }]
            },
            {
                "id": 8,
                "text": "Preparing workplaces",
                "type": "task",
                "start_date": "14-04-2019 00:00",
                "duration": 5,
                "parent": "4",
                "progress": 0.5,
                "owner": [{
                    "resource_id": "10",
                    "value": 4
                }, {
                    "resource_id": "9",
                    "value": 5
                }],
                "priority": 1
            },
            {
                "id": 9,
                "text": "Workplaces importation",
                "type": "task",
                "start_date": "21-04-2019 00:00",
                "duration": 4,
                "parent": "4",
                "progress": 0.5,
                "owner": [{
                    "resource_id": "7",
                    "value": 3
                }]
            },
            {
                "id": 10,
                "text": "Workplaces exportation",
                "type": "task",
                "start_date": "27-04-2019 00:00",
                "duration": 3,
                "parent": "4",
                "progress": 0.5,
                "owner": [{
                    "resource_id": "8",
                    "value": 5
                }],
                "priority": 2
            },
            {
                "id": 11,
                "text": "Product launch",
                "type": "project",
                "progress": 0.6,
                "start_date": "02-04-2019 00:00",
                "duration": 13,
                "owner": [{
                    "resource_id": "5",
                    "value": 4
                }],
                "parent": 0
            },
            {
                "id": 12,
                "text": "Perform Initial testing",
                "type": "task",
                "start_date": "03-04-2019 00:00",
                "duration": 5,
                "parent": "11",
                "progress": 1,
                "owner": [{
                    "resource_id": "7",
                    "value": 6
                }]
            },
            {
                "id": 13,
                "text": "Development",
                "type": "project",
                "start_date": "03-04-2019 00:00",
                "duration": 11,
                "parent": "11",
                "progress": 0.5,
                "owner": [{
                    "resource_id": "5",
                    "value": 2
                }]
            },
            {
                "id": 14,
                "text": "Analysis",
                "type": "task",
                "start_date": "03-04-2019 00:00",
                "duration": 6,
                "parent": "11",
                "owner": [],
                "progress": 0.8
            },
            {
                "id": 15,
                "text": "Design",
                "type": "project",
                "start_date": "03-04-2019 00:00",
                "duration": 5,
                "parent": "11",
                "progress": 0.2,
                "owner": [{
                    "resource_id": "5",
                    "value": 5
                }]
            },
            {
                "id": 16,
                "text": "Documentation creation",
                "type": "task",
                "start_date": "03-04-2019 00:00",
                "duration": 7,
                "parent": "11",
                "progress": 0,
                "owner": [{
                    "resource_id": "7",
                    "value": 2
                }],
                "priority": 1
            },
            {
                "id": 17,
                "text": "Develop System",
                "type": "task",
                "start_date": "03-04-2019 00:00",
                "duration": 2,
                "parent": "13",
                "progress": 1,
                "owner": [{
                    "resource_id": "8",
                    "value": 1
                }],
                "priority": 2
            },
            {
                "id": 25,
                "text": "Beta Release",
                "type": "milestone",
                "start_date": "06-04-2019 00:00",
                "parent": "13",
                "progress": 0,
                "owner": [{
                    "resource_id": "5",
                    "value": 1
                }],
                "duration": 0
            },
            {
                "id": 18,
                "text": "Integrate System",
                "type": "task",
                "start_date": "10-04-2019 00:00",
                "duration": 2,
                "parent": "13",
                "progress": 0.8,
                "owner": [{
                    "resource_id": "6",
                    "value": 2
                }],
                "priority": 3
            },
            {
                "id": 19,
                "text": "Test",
                "type": "task",
                "start_date": "13-04-2019 00:00",
                "duration": 4,
                "parent": "13",
                "progress": 0.2,
                "owner": [{
                    "resource_id": "6",
                    "value": 3
                }]
            },
            {
                "id": 20,
                "text": "Marketing",
                "type": "task",
                "start_date": "13-04-2019 00:00",
                "duration": 4,
                "parent": "13",
                "progress": 0,
                "owner": [{
                    "resource_id": "8",
                    "value": 4
                }],
                "priority": 1
            },
            {
                "id": 21,
                "text": "Design database",
                "type": "task",
                "start_date": "03-04-2019 00:00",
                "duration": 4,
                "parent": "15",
                "progress": 0.5,
                "owner": [{
                    "resource_id": "6",
                    "value": 5
                }]
            },
            {
                "id": 22,
                "text": "Software design",
                "type": "task",
                "start_date": "03-04-2019 00:00",
                "duration": 4,
                "parent": "15",
                "progress": 0.1,
                "owner": [{
                    "resource_id": "8",
                    "value": 3
                }],
                "priority": 1
            },
            {
                "id": 23,
                "text": "Interface setup",
                "type": "task",
                "start_date": "03-04-2019 00:00",
                "duration": 5,
                "parent": "15",
                "progress": 0,
                "owner": [{
                    "resource_id": "8",
                    "value": 5
                }],
                "priority": 1
            },
            {
                "id": 24,
                "text": "Release v1.0",
                "type": "milestone",
                "start_date": "20-04-2019 00:00",
                "parent": "11",
                "progress": 0,
                "owner": [{
                    "resource_id": "5",
                    "value": 3
                }],
                "duration": 0
            }
        ],
        "links": [

            {
                "id": "2",
                "source": "2",
                "target": "3",
                "type": "0"
            },
            {
                "id": "3",
                "source": "3",
                "target": "4",
                "type": "0"
            },
            {
                "id": "7",
                "source": "8",
                "target": "9",
                "type": "0"
            },
            {
                "id": "8",
                "source": "9",
                "target": "10",
                "type": "0"
            },
            {
                "id": "16",
                "source": "17",
                "target": "25",
                "type": "0"
            },
            {
                "id": "17",
                "source": "18",
                "target": "19",
                "type": "0"
            },
            {
                "id": "18",
                "source": "19",
                "target": "20",
                "type": "0"
            },
            {
                "id": "22",
                "source": "13",
                "target": "24",
                "type": "0"
            },
            {
                "id": "23",
                "source": "25",
                "target": "18",
                "type": "0"
            }

        ]
    })

  
</script>

</html>