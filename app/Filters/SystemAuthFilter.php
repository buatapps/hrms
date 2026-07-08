<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class SystemAuthFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return RequestInterface|ResponseInterface|string|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $path = trim(str_replace(base_url(), '', current_url()), '/');

        // 🔥 WHITELIST: jangan kena filter
        $allowed = [
            'hrms/tools/auth-key',
            'tools/auth-key',
            'tools/create-auth'
        ];

        if (in_array($path, $allowed)) {
            return;
        }

        $model = new \App\Models\ToolsModel();
        $auth = $model->where('is_active', 1)->first();

        if (!$auth) {
            return redirect()->to('/tools/auth-key');
        }

        $data = json_decode(base64_decode($auth['auth_key']), true);

        if (!$data) {
            return redirect()->to('/tools/auth-key');
        }

        $today = date('Y-m-d');

        if ($today > $data['auth_date']) {
            return redirect()->to('/tools/auth-key');
        }
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return ResponseInterface|void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
