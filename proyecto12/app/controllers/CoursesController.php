<?php

class CoursesController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model('Course');
    }

    public function index()
    {


            $courses = $this->model->getCourses();

            $data = [
                'titulo' => 'Cursos en línea',
                'menu' => true,
                'active' => 'courses',
                'data' => $courses,
            ];

            $this->view('courses/index', $data);


    }
}