//
//  hardMazeViewController.m
//  maze_practice
//
//  Created by g-2015 on 2013/08/21.
//  Copyright (c) 2013年 g-2015. All rights reserved.
//

#import "hardMazeViewController.h"
#import "clearViewController.h"

@interface hardMazeViewController ()

@end

@implementation hardMazeViewController

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
	// Do any additional setup after loading the view.
    
    //迷路の初期か
    //棒倒し法
    for(int i = 0; i < 21; i++){
        for(int j = 0; j < 21; j++){
            //外枠+偶数の場所に棒をたてる
            if(i == 0 || i == 20 || j == 0 || j == 20 || (i % 2 == 0 && j % 2 == 0)){
                maze_H[i][j] = 1;
            }else{
                maze_H[i][j] = 0;
            }
        }
    }
    for(int i = 2; i <= 18; i += 2){    //棒を倒して行く
        for(int j = 2; j <= 18; j += 2){
            while(1){
                int random_number;
                if(i == 2){ //一番上は上下左右に倒す、それ以外は下左右に倒す
                    random_number = arc4random() % 4;
                }else{
                    random_number = arc4random() % 3;
                }
                if(random_number == 0){//左に壁がなかったら左に棒を倒す
                    if(maze_H[i][j-1] == 0){
                        maze_H[i][j-1] = 1;
                        break;
                    }
                }else if(random_number == 1){//したに壁がなかったら下に棒を倒す
                    if(maze_H[i+1][j] == 0){
                        maze_H[i+1][j] = 1;
                        break;
                    }
                }else if(random_number == 2){//右に壁がなかったら右に棒を倒す
                    if(maze_H[i][j+1] == 0){
                        maze_H[i][j+1] = 1;
                        break;
                    }
                }else if(random_number == 3){//上に壁がなかったら上に棒を倒す
                    if(maze_H[i-1][j] == 0){
                        maze_H[i-1][j] = 1;
                        break;
                    }
                }
            }
        }
    }
    
    //迷路の表示
    for(int i = 0; i < 21; i++){
        for(int j = 0; j < 21; j++){
            mazeImage_H[i][j] = [[UIImageView alloc] initWithFrame:CGRectMake(i*60+70, j*60+136, 60, 60)];
            if(maze_H[i][j] == 1){
                mazeImage_H[i][j].image = [UIImage imageNamed:@"wall.png"];
            }else{
                mazeImage_H[i][j].image = [UIImage imageNamed:@"floor.png"];
            }
            [self.view addSubview:mazeImage_H[i][j]];
            [self.view sendSubviewToBack:mazeImage_H[i][j]];
        }
    }
    
    //キャラの表示
    charaPos_H[0] = 1;
    charaPos_H[1] = 1;
    charaGraphCount_H = 0;
    //キャラ画像取り込み
    //イメージを分割する
    UIImage *chara_i_H = [UIImage imageNamed:@"vx_chara04_a.png"];
    for(int i = 0; i < 2; i++){
        CGRect rect_H = CGRectMake((i*2+3)*(chara_i_H.size.width/12), 1*(chara_i_H.size.height/8), chara_i_H.size.width/12, chara_i_H.size.height/8);
        charaGraph_H[0][i] = [self imageByCropping:chara_i_H toRect:rect_H]; //0→左
        rect_H = CGRectMake((i*2+3)*(chara_i_H.size.width/12), 0*(chara_i_H.size.height/8), chara_i_H.size.width/12, chara_i_H.size.height/8);
        charaGraph_H[1][i] = [self imageByCropping:chara_i_H toRect:rect_H]; //1→下
        rect_H = CGRectMake((i*2+3)*(chara_i_H.size.width/12), 2*(chara_i_H.size.height/8), chara_i_H.size.width/12, chara_i_H.size.height/8);
        charaGraph_H[2][i] = [self imageByCropping:chara_i_H toRect:rect_H]; //2→右
        rect_H = CGRectMake((i*2+3)*(chara_i_H.size.width/12), 3*(chara_i_H.size.height/8), chara_i_H.size.width/12, chara_i_H.size.height/8);
        charaGraph_H[3][i] = [self imageByCropping:chara_i_H toRect:rect_H]; //3→上
    }
    charaImage_H = [[UIImageView alloc] initWithFrame:CGRectMake(charaPos_H[0]*60+70, charaPos_H[1]*60+136, 60, 60)];
    charaImage_H.image = charaGraph_H[1][0];   //初期は下向き
    [self.view addSubview:charaImage_H];
    
    //ゴールの表示(とりあえず位置は19、19)
    goalImage_H = [[UIImageView alloc] initWithFrame:CGRectMake(19*60+70, 19*60+136, 60, 60)];
    goalImage_H.image = [UIImage imageNamed:@"goal2.png"];
    [self.view addSubview:goalImage_H];
    
    //タイムの初期化
    remainingTime_H = 60;
    self.timeLabel_H.text = [NSString stringWithFormat:@"%d", remainingTime_H];
    
    //タイムを動かす
    customtimer_H = [NSTimer scheduledTimerWithTimeInterval:1.0
                                                   target:self
                                                 selector:@selector(timeAction_H:)
                                                 userInfo:nil
                                                  repeats:YES];
    if([customtimer_H isValid]){
        NSLog(@"ハードのタイマーが動き始めた");
    }


}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

//左に行けるかの判定＆移動
- (void)cahraMoveLeft_H{
    charaGraphCount_H++;
    charaImage_H.image = charaGraph_H[0][charaGraphCount_H%2];   //左を向く
    if(maze_H[charaPos_H[0]-1][charaPos_H[1]] == 0){
        
        charaPos_H[0]--;
        [self mezeDisplay_H];
    }

}

//左ボタンが押したら動く
- (IBAction)leftBtnDown_H:(id)sender {
    btnTimer_H[0] = [NSTimer scheduledTimerWithTimeInterval:0.4
                                                   target:self
                                                 selector:@selector(cahraMoveLeft_H)
                                                 userInfo:nil
                                                  repeats:YES];
    if([btnTimer_H[0] isValid]){
        [self cahraMoveLeft_H];
        NSLog(@"ハードボタンタイマー0が動き始めた");
    }

}

//左ボタンが離されたら動く
- (IBAction)leftBtn_H:(id)sender {
    [btnTimer_H[0] invalidate];
    NSLog(@"ハードボタンタイマー0を止めた");

}

//上に行けるかの判定＆移動
- (void)cahraMoveUp_H{
    charaGraphCount_H++;
    charaImage_H.image = charaGraph_H[3][charaGraphCount_H%2];   //上を向く
    if(maze_H[charaPos_H[0]][charaPos_H[1]-1] == 0){
                charaPos_H[1]--;
        [self mezeDisplay_H];
    }
}

//上ボタンを押したら動く
- (IBAction)upBtnDown_H:(id)sender {
    btnTimer_H[1] = [NSTimer scheduledTimerWithTimeInterval:0.4
                                                   target:self
                                                 selector:@selector(cahraMoveUp_H)
                                                 userInfo:nil
                                                  repeats:YES];
    if([btnTimer_H[1] isValid]){
        [self cahraMoveUp_H];
        NSLog(@"ハードボタンタイマー1が動き始めた");
    }
}

//上ボタンが離されたら動く
- (IBAction)upBtn_H:(id)sender {
    [btnTimer_H[1] invalidate];
    NSLog(@"ハードボタンタイマー1を止めた");

}

//下に行けるかの判定＆移動
- (void)cahraMoveDown_H{
    charaGraphCount_H++;
    charaImage_H.image = charaGraph_H[1][charaGraphCount_H%2];   //下を向く
    if(maze_H[charaPos_H[0]][charaPos_H[1]+1] == 0){
        charaPos_H[1]++;
        [self mezeDisplay_H];
    }
}

//下ボタンを押したら動く
- (IBAction)downBtnDown_H:(id)sender {
    btnTimer_H[2] = [NSTimer scheduledTimerWithTimeInterval:0.4
                                                   target:self
                                                 selector:@selector(cahraMoveDown_H)
                                                 userInfo:nil
                                                  repeats:YES];
    if([btnTimer_H[2] isValid]){
        [self cahraMoveDown_H];
        NSLog(@"ハードボタンタイマー2が動き始めた");
    }
}

//下ボタンが離されたら動く
- (IBAction)dwonBtn_H:(id)sender {
    [btnTimer_H[2] invalidate];
    NSLog(@"ハードボタンタイマー2を止めた");
}

//右に行けるかの判定＆移動
- (void)cahraMoveRight_H{
    charaGraphCount_H++;
    charaImage_H.image = charaGraph_H[2][charaGraphCount_H%2];   //右を向く
    if(maze_H[charaPos_H[0]+1][charaPos_H[1]] == 0){
        charaPos_H[0]++;
        [self mezeDisplay_H];
    }
}

//右ボタンを押したら動く
- (IBAction)rightBtnDown_H:(id)sender {
    btnTimer_H[3] = [NSTimer scheduledTimerWithTimeInterval:0.4
                                                   target:self
                                                 selector:@selector(cahraMoveRight_H)
                                                 userInfo:nil
                                                  repeats:YES];
    if([btnTimer_H[3] isValid]){
        [self cahraMoveRight_H];
        NSLog(@"ハードボタンタイマー3が動き始めた");
    }
}

//右ボタンが離されたら動く
- (IBAction)rightBtn_H:(id)sender {
    [btnTimer_H[3] invalidate];
    NSLog(@"ハードボタンタイマー3を止めた");
}

//タイトルボタン
- (IBAction)titleBtn_H:(id)sender {
    [customtimer_H invalidate];   //タイマーを止める
    [btnTimer_H[0] invalidate];
    [btnTimer_H[1] invalidate];
    [btnTimer_H[2] invalidate];
    [btnTimer_H[3] invalidate];
    NSLog(@"ハードタイマーを止めた");
}

//キャラが動いたときに迷路自体が動くようにする
- (void)mezeDisplay_H{
    if(charaPos_H[0] == 19 && charaPos_H[1] == 19){ //ゴール判定
        [customtimer_H invalidate];   //タイマーを止める
        [btnTimer_H[0] invalidate];
        [btnTimer_H[1] invalidate];
        [btnTimer_H[2] invalidate];
        [btnTimer_H[3] invalidate];
        NSLog(@"ハードタイマーを止めた");
        [self performSegueWithIdentifier:@"clearView_H" sender:self]; //クリア画面へ移行
    }
     NSLog(@"%d,%d", charaPos_H[0], charaPos_H[1]);
    //迷路の表示
    for(int i = 0; i < 21; i++){
        for(int j = 0; j < 21; j++){
            //mazeImage_H[i][j] = [[UIImageView alloc] initWithFrame:CGRectMake(i*60+70, j*60+136, 60, 60)];
            mazeImage_H[i][j].center = CGPointMake(i*60+70+30-(charaPos_H[0]*60-60), j*60+136+30-(charaPos_H[1]*60-60));
        }
    }
    goalImage_H.center = CGPointMake(19*60+70+30-(charaPos_H[0]*60-60), 19*60+136+30-(charaPos_H[1]*60-60));

    
}

//タイムアクション（１秒ごとに呼ばれる）
- (void)timeAction_H:(id)sender{
    NSTimer *timer_H = sender;
    
    if([timer_H isValid]){
        remainingTime_H--;
        if(remainingTime_H == 0){
            [customtimer_H invalidate];   //タイマーを止める
            [btnTimer_H[0] invalidate];
            [btnTimer_H[1] invalidate];
            [btnTimer_H[2] invalidate];
            [btnTimer_H[3] invalidate];
            NSLog(@"ハードタイマーを止めた");
           [self performSegueWithIdentifier:@"gameOverView_H" sender:self]; //ゲームオーバー画面へ移行
        }
        self.timeLabel_H.text = [NSString stringWithFormat:@"%d", remainingTime_H]; //時間表示
    }
}


//画像を切り抜くときに使う
- (UIImage *)imageByCropping:(UIImage *)crop toRect:(CGRect)rect
{
    // 指定した四角でイメージを切り抜き
    CGImageRef imageRef = CGImageCreateWithImageInRect([crop CGImage], rect);
    UIImage *cropped = [UIImage imageWithCGImage:imageRef];
    CGImageRelease(imageRef);
    return cropped;
}

//view移動したときの値渡しでつかう
-(void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender
{
    //Segueの特定
    if ( [[segue identifier] isEqualToString:@"clearView_H"] ) {
        clearViewController *nextViewController = [segue destinationViewController];
        //ここで遷移先ビューのクラスの変数receiveStringに値を渡している
        nextViewController.clearRemainingTime = remainingTime_H;
    }
}
@end
