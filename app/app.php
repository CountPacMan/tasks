<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Task.php";
    session_start();
    if (empty($_SESSION['taskList'])) {
        $_SESSION['taskList'] = [];
    }
    $app = new Silex\Application();

    $app->get("/", function() {
        $output = "";
        $allTasks = Task::getAll();

        if (!empty($allTasks)) {
            $output .= "
                <h1>To Do List</h1>
                <p>Here are all your tasks:</p>
                <ul>";
            foreach (Task::getAll() as $task) {
                $output .= "<p>" . $task->getDescription() . "</p>";
            }
            $output .= "</ul>";
        }


        $output .= "
            <form action='/tasks' method='post'>
                <label for='description'>Task Description</label>
                <input id='description' name='description' type='text'>

                <button type='submit'>Add task</button>
            </form>";

        return $output;
    });

    $app->post("/tasks", function() {
        $task = new Task($_POST['description']);
        $task->save();
        return "
            <h1>You created a task!</h1>
            <p>" . $task->getDescription() . "</p>
            <p><a href='/'>View your list of things to do.</a></p>";
    });

    return $app;
?>
