<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Repositories\Contracts\MenuRepositoryInterface;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    private $menuRepository;

    public function __construct(MenuRepositoryInterface $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = $this->menuRepository->getMenuOrderBy('priority', 'desc');
        return view('admin.menu.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menus = $this->idTitels();
        return view('admin.menu.create', compact('menus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $menu = $this->menuRepository->store([
            'title' => $request->title,
            'parent_id' => $request->parent == "null" ? null : $request->parent,
            'priority' => $request->priority,
            'link' => $request->link,
            'status' => $request->status
        ]);
        return $this->ResponseSuccess();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Menu $menu
     * @return void
     */
    public function edit(Menu $menu)
    {
        $menus = $this->idTitels();
        return view('admin.menu.edit', compact('menu', 'menus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Menu $menu
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Menu $menu)
    {
        $menu->update([
            'title' => $request->title,
            'parent_id' => $request->parent == "null" ? null : $request->parent,
            'priority' => $request->priority,
            'link' => $request->link,
            'status' => $request->status
        ]);
        return $this->ResponseSuccess();
    }

    public function changeStatus(Menu $menu)
    {
        $menu->update(['status' => $menu->status == 1 ? 2 : 1]);
        return response(['success' => true, 'state' => $menu->status]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Menu $menu
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();
        return $this->ResponseSuccess();
    }

    /**
     * @return mixed
     */
    private function idTitels()
    {
        $menus = $this->menuRepository->IdTitles();
        return $menus;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    private function ResponseSuccess(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => true
        ], 200);
    }
}
