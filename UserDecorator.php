<?php


class UserDecorator
{
    private $params;

    public function __construct( array $params)
    {
        $this->params = $params;
    }

    public function sex($user){
        return (
            (!empty($user['sex']) && $user['sex'] == $this->params['sex']['FEMALE']) ?
                '<i class="fa fa-female" data-toggle="tooltip" data-original-title="Жен"></i>'  :
                '<i class="fa fa-male" data-toggle="tooltip" data-original-title="Муж"></i>'
        );
    }

    public function role($user){
        return $this->params['roles'][$user['role']] ?? 'Unnamed Role';
    }

    public function status($user){
        return !empty($user['status']) ?
            '<i class="fa fa-check" style="color: green" data-toggle="tooltip" data-original-title="Активен"></i>' :
            '<i class="fa fa-ban" style="color: red" data-toggle="tooltip" data-original-title="Забанен"></i>';
    }

    public function avatar($user){
        if (!empty($user['avatar']) && file_exists($this->params['avatars_path'].$user['avatar']))
            $img_address = $this->params['avatars_path'].$user['avatar'];
        elseif ($user['sex'] == $this->params['sex']['FEMALE'])
            $img_address = $this->params['no_avatar_female'];
        else
            $img_address = $this->params['no_avatar_male'];

        if (empty($user['status']))
            $style= 'opacity:0.4;';
        else
            $style= '';

        return
         '<img src="'.$img_address.'" width="75" alt="" style="'.$style.'">' ;
    }
}