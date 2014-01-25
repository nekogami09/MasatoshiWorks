//
//  mazeViewController.h
//  maze_butn
//
//  Created by g-2015 on 2013/08/17.
//  Copyright (c) 2013年 g-2015. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface mazeViewController : UIViewController{
    //NSMutableArray *maze;
    int maze[21][21]; //迷路の
    UIImageView *mazeImage[21][21];   //迷路の画像
    UIImageView *charaImage;    //プレイヤーキャラ画像
    UIImage *charaGraph[4][2];
    unsigned int charaGraphCount;
    int charaPos[2];    //キャラの座標x、y
    UIImageView *goalImage; //ゴール画像
    int remainingTime;      //残り時間
    NSTimer *customtimer;   //タイマー
    NSTimer *btnTimer[4];  //ボタンを押したら動くタイマー
}
@property (weak, nonatomic) IBOutlet UILabel *timeLabel;

- (void)timeAction:(id)sender;      //
- (void)cahraMoveLeft;              //
- (IBAction)leftBtnDown:(id)sender; //
- (IBAction)leftBtn:(id)sender;     //
- (void)cahraMoveUp;                //
- (IBAction)upBtnDown:(id)sender;
- (IBAction)upBtn:(id)sender;       //
- (void)cahraMoveDown;              //
- (IBAction)downBtnDown:(id)sender;
- (IBAction)downBtn:(id)sender;     //
- (void)cahraMoveRight;             //
- (IBAction)rightBtnDown:(id)sender;
- (IBAction)rightBtn:(id)sender;    //
- (IBAction)titleBtn:(id)sender;    //

@end
