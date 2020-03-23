<?php

class View
{
    function show($templateName, $data = [])
    {
        include $templateName;
    }
    
	function generateToolBar($data) {
		$html = '';
		$from = $data['result']['pageNumber']-2;
            $to = $data['result']['pageNumber']+2;
            if ($from < 2) {
              $from = 1; 
            }
            if ($to > $data['result']['allPages']) {
              $to = $data['result']['allPages'];
            }
            $html .= '<a href="/home/index/1">';
            $html .= '<button class="btn btn-dark"><<</button></a>';
            for ($i = $from; $i < $to+1; $i++) {
              if ($i == $data['result']['pageNumber']) {
                $html .= '<button class="btn btn-light">' . 
                $data['result']['pageNumber'] . '</button>';
              } else {
                $html .= '<a href="/home/index/' . $i . '">';
                $html .= '<button class="btn btn-dark">' . $i . '</button></a>';
              }
            }
            $html .= '<a href="/home/index/' . $data['result']['allPages'] . '">';
            $html .= '<button class="btn btn-dark">>></button></a>';
		return $html;
	}

	function generateTable($data) {
		$htmlTableBody = '';
		foreach ($data['result']['taskData'] as $k => $v) {
			$htmlTableBody .= '<tr>';
			$htmlTableBody .= '<td>' . $v['username'] . '</td>';
			$htmlTableBody .= '<td>' . $v['email'] . '</td>';
			$htmlTableBody .= '<td class="tsk_' . $v['taskID'] . '">' . 
			$v['tasktext'] . '</td>';
			$htmlTableBody .= '<td>' . $this->hStatus($v['status']) . '</td>';
			if (!empty($data['admin'])) {
				$htmlTableBody .= '<td><button type="button" ' .
				    ' class="check_admin_btn" data-id="' . $v['taskID'] . 
				    '">CHECK</button>';
				$htmlTableBody .= '<button type="button" ' .
				    ' class="edit_admin_btn" data-id="' . $v['taskID'] . 
				    '">EDIT</button></td>';
			} else {
				$htmlTableBody .= '<td>No option</td>';
			}
			$htmlTableBody .= '</tr>';
		  }
		return $htmlTableBody;
    }
    
    function hStatus($status) 
    {
        $hStat = $status;
        switch ($status) {
            case 'new': 
                $hStat = 'новое';
                break;
            case 'edited': 
                $hStat = 'отредактировано админом';
                break;
            case 'done': 
                $hStat = 'выполнено';
                break;
            case 'done_edited': 
                $hStat = 'отредактировано админом <br /> выполнено';
                break;
        }
        return $hStat;
    }
}

