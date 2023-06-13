<!DOCTYPE html>

<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <title>Material theme</title>
    <script src="https://docs.dhtmlx.com/gantt/codebase/dhtmlxgantt.js?v=8.0.1"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto:regular,medium,thin,bold">
    <link rel="stylesheet" href="https://docs.dhtmlx.com/gantt/codebase/skins/dhtmlxgantt_material.css?v=8.0.1">
    <link rel="stylesheet" href="https://docs.dhtmlx.com/gantt/samples/common/controls_styles.css?v=8.0.1">

    <script src="../common/testdata.js?v=8.0.1"></script>
    <style>
        html,
        body {
            background: #fff;
            font-family: arial;
            height: 100%;
            padding: 0px;
            margin: 0px;
            overflow: hidden;
        }

        .main-content {
            height: 600px;
            height: calc(100vh - 50px);
        }
    </style>
</head>

<body>
    <div class="gantt_control">
        <input type="button" value="Show Lightbox" onclick="gantt.createTask()" />
        <input type="button" value="Show Quick Info" onclick="if (gantt.getTaskByTime()[0]) gantt.showQuickInfo(gantt.getTaskByTime()[0].id)" />
        <input type="button" value="Show message" onclick="gantt.message({text:'Some text',expire:50000})" />
        <input type="button" value="Show error" onclick="gantt.message({text:'Some text', type:'error'})" />
        <input type="button" value="Show alert" onclick="gantt.alert({text:'Some text'})" />
        <input type="button" value="Show alert with header" onclick="gantt.alert({text:'Some text', title:'Title'})" />
        <input type="button" value="Show critical" onclick="toggleCritical()" />
    </div>
    <div class="main-content">
        <div id="gantt_here" style='width:100%; height:100%;padding: 0px;'></div>
    </div>

    <script>
        gantt.plugins({
            quick_info: true,
            tooltip: true,
            critical_path: true
        });

        var toggleCritical = function() {
            if (gantt.config.highlight_critical_path)
                gantt.config.highlight_critical_path = !true;
            else
                gantt.config.highlight_critical_path = true;
            gantt.render();
        };

        gantt.config.columns = [{
                name: "wbs",
                label: "WBS",
                width: 40,
                template: gantt.getWBSCode,
                resize: true
            },
            {
                name: "text",
                label: "Task name",
                tree: true,
                width: 170,
                resize: true,
                min_width: 10
            },
            {
                name: "start_date",
                align: "center",
                width: 90,
                resize: true
            },
            {
                name: "duration",
                align: "center",
                width: 80,
                resize: true
            },
            {
                name: "add",
                width: 40
            }
        ];

        gantt.templates.rightside_text = function(start, end, task) {
            if (task.type == gantt.config.types.milestone)
                return task.text + " / ID: #" + task.id;
            return "";
        };

        gantt.config.start_on_monday = false;
        gantt.config.scale_height = 36 * 3;
        gantt.config.scales = [{
                unit: "month",
                step: 1,
                format: "%F"
            },
            {
                unit: "week",
                step: 1,
                format: function(date) {
                    var dateToStr = gantt.date.date_to_str("%d %M");
                    var endDate = gantt.date.add(gantt.date.add(date, 1, "week"), -1, "day");
                    return dateToStr(date) + " - " + dateToStr(endDate);
                }
            },
            {
                unit: "day",
                step: 1,
                format: "%D"
            }
        ];

        gantt.init("gantt_here");
        gantt.message({
            text: "Some text",
            expire: -1
        });
        gantt.message({
            text: "Some text",
            type: "error",
            expire: -1
        });
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
        });
    </script>

    <script>
        (function(i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function() {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-11031269-1', 'auto');
        ga('send', 'pageview');
    </script>
    <script src="https://cdn.ravenjs.com/3.10.0/raven.min.js"></script>
    <script>
        Raven.config('https://25a6d5e8c35148d195a1967d8374ffca@sentry.dhtmlx.ru/6').install()
    </script>
</body>