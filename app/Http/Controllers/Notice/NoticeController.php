<?php

namespace App\Http\Controllers\Notice;

use App\Http\Controllers\AuthController;
use App\Oms\Notice\Manager;
use App\Oms\Notice\Queries\ListNotices;
use Illuminate\Http\Request;

/**
 * Class NoticeController
 * @package App\Http\Controllers\Notice
 */
class NoticeController extends AuthController
{
    /**
     * @var Manager
     */
    protected $notice;

    /**
     * NoticeController constructor.
     * @param Manager $notice
     */
    public function __construct(Manager $notice)
    {
        parent::__construct();
        $this->notice = $notice;
    }

    /**
     * @param ListNotices $listNotices
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(ListNotices $listNotices)
    {
        $notices = $listNotices->all();
        return view('oms.pages.notices.index', compact('notices'));
    }

    public function create()
    {
        return view('oms.pages.notices.create');
    }

    public function store(Request $request)
    {
        $noticeDetail = $request->validate(['notice' => 'required']);
        $noticeDetail['user_id'] = $request->user()->id;
        $this->notice->create($noticeDetail);

        return redirect()->route('notices.index');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $notice = $this->notice->getDetail($id);
        return view('oms.pages.notices.show', compact('notice'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $notice = $this->notice->find($id);
        $this->notice->delete($notice);

        return redirect()->route('notices.index');
    }
}