//
//  mazeViewController.m
//  maze_butn
//
//  Created by g-2015 on 2013/08/17.
//  Copyright (c) 2013年 g-2015. All rights reserved.
//

#import "mazeViewController.h"
#import "clearViewController.h"

@interface mazeViewController ()

@end

@implementation mazeViewController

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
    //[self display];
    //迷路の初期か
    //棒倒し法
    for(int i = 0; i < 21; i++){
        for(int j = 0; j < 21; j++){
            //外枠+偶数の場所に棒をたてる
            if(i == 0 || i == 20 || j == 0 || j == 20 || (i % 2 == 0 && j % 2 == 0)){
                maze[i][j] = 1;
            }else{
                maze[i][j] = 0;
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
                    if(maze[i][j-1] == 0){
                        maze[i][j-1] = 1;
                        break;
                    }
                }else if(random_number == 1){//したに壁がなかったら下に棒を倒す
                    if(maze[i+1][j] == 0){
                        maze[i+1][j] = 1;
                        break;
                    }
                }else if(random_number == 2){//右に壁がなかったら右に棒を倒す
                    if(maze[i][j+1] == 0){
                        maze[i][j+1] = 1;
                        break;
                    }
                }else if(random_number == 3){//上に壁がなかったら上に棒を倒す
                    if(maze[i-1][j] == 0){
                        maze[i-1][j] = 1;
                        break;
                    }
                }
            }
        }
    }

    //迷路の表示
    for(int i = 0; i < 21; i++){
        for(int j = 0; j < 21; j++){
            mazeImage[i][j] = [[UIImageView alloc] initWithFrame:CGRectMake(i*15, j*15+50, 15, 15)];
            if(maze[i][j] == 1){
                mazeImage[i][j].image = [UIImage imageNamed:@"wall.png"];
            }else{
                mazeImage[i][j].image = [UIImage imageNamed:@"floor.png"];
            }
            [self.view addSubview:mazeImage[i][j]];
            [self.view sendSubviewToBack:mazeImage[i][j]];
        }
    }

    //キャラの表示
    charaPos[0] = 1;
    charaPos[1] = 1;
    charaGraphCount = 0;
    //キャラ画像取り込み
    //イメージを分割する
    UIImage *chara_i = [UIImage imageNamed:@"vx_chara04_a.png"];
    for(int i = 0; i < 2; i++){
        CGRect rect = CGRectMake(i*2*(chara_i.size.width/12), 1*(chara_i.size.height/8), chara_i.size.width/12, chara_i.size.height/8);
        charaGraph[0][i] = [self imageByCropping:chara_i toRect:rect]; //0→左
        rect = CGRectMake(i*2*(chara_i.size.width/12), 0*(chara_i.size.height/8), chara_i.size.width/12, chara_i.size.height/8);
        charaGraph[1][i] = [self imageByCropping:chara_i toRect:rect]; //1→下
        rect = CGRectMake(i*2*(chara_i.size.width/12), 2*(chara_i.size.height/8), chara_i.size.width/12, chara_i.size.height/8);
        charaGraph[2][i] = [self imageByCropping:chara_i toRect:rect]; //2→右
        rect = CGRectMake(i*2*(chara_i.size.width/12), 3*(chara_i.size.height/8), chara_i.size.width/12, chara_i.size.height/8);
        charaGraph[3][i] = [self imageByCropping:chara_i toRect:rect]; //3→上
    }
    charaImage = [[UIImageView alloc] initWithFrame:CGRectMake(charaPos[0]*15-7.5, charaPos[1]*15+50-7.5, 30, 30)];
    charaImage.image = charaGraph[1][0];   //初期は下向き
    [self.view addSubview:charaImage];
    
    //ゴールの表示(とりあえず位置は19、19)
    goalImage = [[UIImageView alloc] initWithFrame:CGRectMake(19*15, 19*15+50, 15, 15)];
    goalImage.image = [UIImage imageNamed:@"goal2.png"];
    [self.view addSubview:goalImage];
    
    //タイムの初期化
    remainingTime = 60;
    self.timeLabel.text = [NSString stringWithFormat:@"%d", remainingTime];
    
    //タイムを動かす
    customtimer = [NSTimer scheduledTimerWithTimeInterval:1.0
                                                            target:self
                                                          selector:@selector(timeAction:)
                                                          userInfo:nil
                                                           repeats:YES];
    if([customtimer isValid]){
        NSLog(@"タイマーが動き始めた");
    }

}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

//左に行けるかの判定＆移動
- (void)cahraMoveLeft{
    charaGraphCount++;
    charaImage.image = charaGraph[0][charaGraphCount%2];   //左を向く
    if(maze[charaPos[0]-1][charaPos[1]] == 0){
        charaPos[0]--;
        if(charaPos[0] == 19 && charaPos[1] == 19){ //ゴール判定
            [customtimer invalidate];   //タイマーを止める
            [btnTimer[0] invalidate];
            [btnTimer[1] invalidate];
            [btnTimer[2] invalidate];
            [btnTimer[3] invalidate];
            NSLog(@"タイマーを止めた");
            [self performSegueWithIdentifier:@"clearView" sender:self]; //クリア画面へ移行
        }
    }
    NSLog(@"%d,%d", charaPos[0], charaPos[1]);
    charaImage.center = CGPointMake(charaPos[0]*15+7.5, charaPos[1]*15+7.5+50);
    
}

//左ボタンが押したら動く
- (IBAction)leftBtnDown:(id)sender {
    btnTimer[0] = [NSTimer scheduledTimerWithTimeInterval:0.4
                                     target:self
                                              selector:@selector(cahraMoveLeft)
                                   userInfo:nil
                                    repeats:YES];
    if([btnTimer[0] isValid]){
        [self cahraMoveLeft];
        NSLog(@"ボタンタイマー0が動き始めた");
    }

}

//左ボタンが離されたら動く
- (IBAction)leftBtn:(id)sender {
    [btnTimer[0] invalidate];
    NSLog(@"ボタンタイマー0を止めた");
}

//上に行けるかの判定＆移動
- (void)cahraMoveUp{
    charaGraphCount++;
    charaImage.image = charaGraph[3][charaGraphCount%2];   //上を向く
    if(maze[charaPos[0]][charaPos[1]-1] == 0){
        charaPos[1]--;
        if(charaPos[0] == 19 && charaPos[1] == 19){ //ゴール判定
            [customtimer invalidate];   //タイマーを止める
            [btnTimer[0] invalidate];
            [btnTimer[1] invalidate];
            [btnTimer[2] invalidate];
            [btnTimer[3] invalidate];
            NSLog(@"タイマーを止めた");
            [self performSegueWithIdentifier:@"clearView" sender:self]; //クリア画面へ移行
        }
    }
    NSLog(@"%d,%d", charaPos[0], charaPos[1]);
    charaImage.center = CGPointMake(charaPos[0]*15+7.5, charaPos[1]*15+7.5+50);

}

//上ボタンを押したら動く
- (IBAction)upBtnDown:(id)sender {
    btnTimer[1] = [NSTimer scheduledTimerWithTimeInterval:0.4
                                                   target:self
                                                 selector:@selector(cahraMoveUp)
                                                 userInfo:nil
                                                  repeats:YES];
    if([btnTimer[1] isValid]){
        [self cahraMoveUp];
        NSLog(@"ボタンタイマー1が動き始めた");
    }
}

//上ボタンが離されたら動く
- (IBAction)upBtn:(id)sender {
    [btnTimer[1] invalidate];
    NSLog(@"ボタンタイマー1を止めた");
}

//下に行けるかの判定＆移動
- (void)cahraMoveDown{
    charaGraphCount++;
    charaImage.image = charaGraph[1][charaGraphCount%2];   //下を向く
    if(maze[charaPos[0]][charaPos[1]+1] == 0){        
        charaPos[1]++;
        if(charaPos[0] == 19 && charaPos[1] == 19){ //ゴール判定
            [customtimer invalidate];   //タイマーを止める
            [btnTimer[0] invalidate];
            [btnTimer[1] invalidate];
            [btnTimer[2] invalidate];
            [btnTimer[3] invalidate];
            NSLog(@"タイマーを止めた");
            [self performSegueWithIdentifier:@"clearView" sender:self]; //クリア画面へ移行
        }
    }
    NSLog(@"%d,%d", charaPos[0], charaPos[1]);
    charaImage.center = CGPointMake(charaPos[0]*15+7.5, charaPos[1]*15+7.5+50);
}

//下ボタンを押したら動く
- (IBAction)downBtnDown:(id)sender {
    btnTimer[2] = [NSTimer scheduledTimerWithTimeInterval:0.4
                                                   target:self
                                                 selector:@selector(cahraMoveDown)
                                                 userInfo:nil
                                                  repeats:YES];
    if([btnTimer[2] isValid]){
        [self cahraMoveDown];
        NSLog(@"ボタンタイマー2が動き始めた");
    }
}

//下ボタンが離されたら動く
- (IBAction)downBtn:(id)sender {
    [btnTimer[2] invalidate];
    NSLog(@"ボタンタイマー2を止めた");
}

//右に行けるかの判定＆移動
- (void)cahraMoveRight{
    charaGraphCount++;
    charaImage.image = charaGraph[2][charaGraphCount%2];   //右を向く
    if(maze[charaPos[0]+1][charaPos[1]] == 0){
        charaPos[0]++;
        if(charaPos[0] == 19 && charaPos[1] == 19){ //ゴール判定
            [customtimer invalidate];   //タイマーを止める
            [btnTimer[0] invalidate];
            [btnTimer[1] invalidate];
            [btnTimer[2] invalidate];
            [btnTimer[3] invalidate];
            NSLog(@"タイマーを止めた");
            [self performSegueWithIdentifier:@"clearView" sender:self]; //クリア画面へ移行
        }
    }
    NSLog(@"%d,%d", charaPos[0], charaPos[1]);
    charaImage.center = CGPointMake(charaPos[0]*15+7.5, charaPos[1]*15+7.5+50);

}

//右ボタンを押したら動く
- (IBAction)rightBtnDown:(id)sender {
    btnTimer[3] = [NSTimer scheduledTimerWithTimeInterval:0.4
                                                   target:self
                                                 selector:@selector(cahraMoveRight)
                                                 userInfo:nil
                                                  repeats:YES];
    if([btnTimer[3] isValid]){
        [self cahraMoveRight];
        NSLog(@"ボタンタイマー3が動き始めた");
    }
}

//右ボタンが離されたら動く
- (IBAction)rightBtn:(id)sender {
    [btnTimer[3] invalidate];
    NSLog(@"ボタンタイマー3を止めた");
}

//タイトルボタン
- (IBAction)titleBtn:(id)sender {
    [customtimer invalidate];   //タイマーを止める
    [btnTimer[0] invalidate];
    [btnTimer[1] invalidate];
    [btnTimer[2] invalidate];
    [btnTimer[3] invalidate];
    NSLog(@"タイマーを止めた");
}

//タイムアクション（１秒ごとに呼ばれる）
- (void)timeAction:(id)sender{
    NSTimer *timer = sender;
    
    if([timer isValid]){
        remainingTime--;
        if(remainingTime == 0){
            [customtimer invalidate];   //タイマーを止める
            [btnTimer[0] invalidate];
            [btnTimer[1] invalidate];
            [btnTimer[2] invalidate];
            [btnTimer[3] invalidate];
            NSLog(@"タイマーを止めた");
            [self performSegueWithIdentifier:@"gameOverView" sender:self]; //クリア画面へ移行
        }
        self.timeLabel.text = [NSString stringWithFormat:@"%d", remainingTime]; //時間表示
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
    if ( [[segue identifier] isEqualToString:@"clearView"] ) {
        clearViewController *nextViewController = [segue destinationViewController];
        //ここで遷移先ビューのクラスの変数receiveStringに値を渡している
        nextViewController.clearRemainingTime = remainingTime;
    }
}
@end
