var exampleQuestions = [

    // QText
    {"type":"0", "content":{
        "content":"What is your name?",
        "placeholder":"name",
        "multiline":"false",
        "required":"true"
    }}
,
    // QCheck
    {"type":"1", "content":{
        "content":"What is your favorite color?",
        "choices":["Red","Blue","Green"],
        "radio":"true",
        "required":"true"
    }}
,
    // QDrop
    {"type":"2", "content":{
        "content":"Choose some:",
        "choices":["1","2","3","4","5"],
        "multiple":"true",
        "required":"false"
    }}
,
    // QSlider
    {"type":"3", "content":{
        "content":"Rate this site:",
        "start":"0.0",
        "end":"10.0",
        "interval":"1.0",
        "required":"true"
    }}
];

var exampleResponses = [

    [// Response for 'Test Surey 3'
        {"qid":5,"answer":"Andrew"},
        {"qid":6,"answer":"This is test data and this is a test comment."},
        {"qid":7,"answer":["Blue","Green"]},
        {"qid":8,"answer":["4"]}
    ]
,
    [// Another response for 'Test Survey 3'
        {"qid":5,"answer":"John Doe"},
        {"qid":6,"answer":"This is more test data and this is another test comment."},
        {"qid":7,"answer":["Red"]},
        {"qid":8,"answer":["2"]}
    ]

];